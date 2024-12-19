<?php

namespace App\Http\Controllers\Employee;

use App\Helpers\CompareDistance;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\ConfigAttendance;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\AttendanceTemporary;
use App\Models\EventAttendance;
use App\Models\Site;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Stevebauman\Location\Facades\Location;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = EventAttendance::whereNotIn('slug', ['machine', 'access-control'])->get();
        return view('_employees.attendances.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function datatable(Request $request)
    {
        // dd($request);
        if ($request->ajax()) {
            // $store = Store::where('user_id', auth()->user()->id)->first();
            $attendances = Attendance::select('*', DB::raw('DATE(timestamp) as date'))
                ->where('employee_id', auth()->user()->employee->id)
                ->with('employee', 'employee.user')
                ->groupBy(['date', 'employee_id'])
                ->orderBy('timestamp', 'desc');

            // $attendances = Attendance::with('event', 'site')->orderBy('timestamp', 'desc');
            // dd($attendances);
            $attendances->get();
            return DataTables::of($attendances)
                ->addIndexColumn()
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('start_date'))) {
                        return $instance->collection = $instance
                            ->whereDate('timestamp', '>=', $request->get('start_date'))
                            ->whereDate('timestamp', '<=', $request->get('end_date'));
                        // ->whereBetween('timestamp', array($request->get('start_date'), $request->get('end_date')));
                    }
                })
                ->addColumn('_in', function ($row) {
                    $data = '';
                    $in = '-';
                    // $out = '-';
                    $attendance = '';

                    $config_masuk = ConfigAttendance::find(1);
                    // $config_pulang = ConfigAttendance::find(2);

                    $in = Attendance::whereTime('timestamp', '<=', $config_masuk->end)->whereTime('timestamp', '>=', $config_masuk->start)->whereDate('timestamp', $row->date)->where('employee_id', $row->employee_id)->orderBy('timestamp', 'ASC')->first();
                    // $out = Attendance::whereTime('timestamp', '>=', $config_pulang->start)->whereDate('timestamp', $row->date)->where('employee_id', $row->employee_id)->latest()->first();

                    if ($in) {
                        $span = '';
                        $color = "bg-success";
                        $distance = 0;
                        $unit = "m";
                        $color_time = 'bg-success';
                        $location = '';

                        if (date('H:i', strtotime($in->timestamp)) > date('H:i', strtotime(config('setting.time_in')))) {
                            $color_time = 'bg-danger';
                        }

                        if ($in->site->latitude != NULL || $in->site->longitude != NULL) {
                            $location = '<a class="badge fs-6 text bg-secondary" href ="http://maps.google.com/maps?q=' . $in->latitude . ',' . $in->longitude . '" target="_blank">Location <i class="bx bx-link-external"></i></a>';

                            if ($in->event_id == 2) {
                                $compare = CompareDistance::getDistance($in->latitude, $in->longitude, $in->site->latitude, $in->site->longitude);
                                $distance = $compare['meters'];

                                if ($distance > 1000) {
                                    $distance = $compare['kilometers'];
                                    $unit = 'Km';
                                    $color = 'bg-danger';
                                } else if ($distance > 100) {
                                    $color = 'bg-warning';
                                }

                                $span = '<span class="badge fs-6 m-1 text bg-primary">' . $in->event->name . '</span><br><span class="badge fs-6 m-1 text bg-success">' . $in->site->name . '</span><span class="badge fs-6 m-1 text ' . $color . ' ">Distance : ' . intval($distance) . ' ' . $unit . '</span>';
                            } else if ($in->event_id == 1) {
                                $site = Site::find(84);
                                $compare = CompareDistance::getDistance($in->latitude, $in->longitude, $site->latitude, $site->longitude);
                                $distance = $compare['meters'];

                                if ($distance > 1000) {
                                    $distance = $compare['kilometers'];
                                    $unit = 'Km';
                                    $color = 'bg-danger';
                                } else if ($distance > 100) {
                                    $color = 'bg-warning';
                                }

                                $span = '<span class="badge fs-6 m-1 text bg-warning">' . $in->event->name . '</span><span class="badge fs-6 m-1 text ' . $color . ' ">Distance : ' . intval($distance) . ' ' . $unit . '</span>';
                            } else {
                                $span = '<span class="badge fs-6 m-1 text bg-info">' . $in->event->name . '</span><span class="badge fs-6 m-1 text ' . $color . ' ">Distance : ' . intval($distance) . ' ' . $unit . '</span>';
                            }
                        } else {
                            $span = '<span class="badge fs-6 m-1 text bg-warning">' . $in->event->name . '</span><span class="badge fs-6 m-1 text ' . $color . ' ">Coordinate site not found</span>';
                        }

                        $attendance = '<span class="badge fs-6 m-1 text ' . $color_time . '">' . DATE('H:i', strtotime($in->timestamp)) . '</span>' . $span . ' ' . $location;
                    }

                    $data = $attendance;
                    return $data;
                })

                ->addColumn('_out', function ($row) {
                    $data = '';
                    $out = '-';
                    // $out = '-';
                    $attendance = '';

                    // $config_masuk = ConfigAttendance::find(1);
                    $config_pulang = ConfigAttendance::find(2);

                    // $out = Attendance::whereTime('timestamp', '<=', $config_masuk->end)->whereDate('timestamp', $row->date)->where('employee_id', $row->employee_id)->oldest()->first();
                    $out = Attendance::whereTime('timestamp', '>=', $config_pulang->start)->whereTime('timestamp', '<=', $config_pulang->end)->whereDate('timestamp', $row->date)->where('employee_id', $row->employee_id)->orderBy('timestamp', 'DESC')->first();

                    if ($out) {
                        $span = '';
                        $color = "bg-success";
                        $distance = 0;
                        $unit = "m";
                        $color_time = 'bg-success';
                        $location = '';

                        if (date('H:i', strtotime($out->timestamp)) < date('H:i', strtotime(config('setting.time_out')))) {
                            $color_time = 'bg-danger';
                        }

                        if ($out->site->latitude != NULL || $out->site->longitude != NULL) {
                            $location = '<a class="badge fs-6 text bg-secondary" href ="http://maps.google.com/maps?q=' . $out->latitude . ',' . $out->longitude . '" target="_blank">Location <i class="bx bx-link-external"></i></a>';

                            if ($out->event_id == 2) {
                                $compare = CompareDistance::getDistance($out->latitude, $out->longitude, $out->site->latitude, $out->site->longitude);
                                $distance = $compare['meters'];

                                if ($distance > 1000) {
                                    $distance = $compare['kilometers'];
                                    $unit = 'Km';
                                    $color = 'bg-danger';
                                } else if ($distance > 100) {
                                    $color = 'bg-warning';
                                }

                                $span = '<span class="badge fs-6 m-1 text bg-primary">' . $out->event->name . '</span><br><span class="badge fs-6 m-1 text bg-success">' . $out->site->name . '</span><span class="badge fs-6 m-1 text ' . $color . ' ">Distance : ' . intval($distance) . ' ' . $unit . '</span>';
                            } else if ($out->event_id == 1) {
                                $site = Site::find(84);
                                $compare = CompareDistance::getDistance($out->latitude, $out->longitude, $site->latitude, $site->longitude);
                                $distance = $compare['meters'];

                                if ($distance > 1000) {
                                    $distance = $compare['kilometers'];
                                    $unit = 'Km';
                                    $color = 'bg-danger';
                                } else if ($distance > 100) {
                                    $color = 'bg-warning';
                                }

                                $span = '<span class="badge fs-6 m-1 text bg-warning">' . $out->event->name . '</span><span class="badge fs-6 m-1 text ' . $color . ' ">Distance : ' . intval($distance) . ' ' . $unit . '</span>';
                            } else {
                                $span = '<span class="badge fs-6 m-1 text bg-info">' . $out->event->name . '</span><span class="badge fs-6 m-1 text ' . $color . ' ">Distance : ' . intval($distance) . ' ' . $unit . '</span>';
                            }
                        } else {
                            $span = '<span class="badge fs-6 m-1 text bg-warning">' . $out->event->name . '</span><span class="badge fs-6 m-1 text ' . $color . ' ">Coordinate site not found</span>';
                        }

                        // $span = '<span class="badge fs-6 m-1 text bg-info">' . $row->event->name . '</span><span class="badge fs-6 m-1 text ' . $color . ' ">Distance : ' . intval($distance) . ' ' . $unit . '</span>';
                        $attendance = '<span class="badge fs-6 m-1 text ' . $color_time . '">' . DATE('H:i', strtotime($out->timestamp)) . '</span>' . $span . ' ' . $location;
                    }

                    $data = $attendance;
                    return $data;
                })

                ->rawColumns(['_in', '_out'])
                ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $validator = $request->validate([
            'event_id' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
            'site_uid' => 'required_if:event_id,2',
            'keterangan' => 'required',
            'photo' => 'required_if:event_id,1',
        ]);

        $config_masuk = ConfigAttendance::find(1);
        $config_pulang = ConfigAttendance::find(2);
        $timestamp = date('Y-m-d H:i:s');
        $site_id = 84;
        try {

            $time = date('H:i:s', strtotime($timestamp));
            if ($time >= $config_masuk->start && $time <= $config_masuk->end) {
                $type = $config_masuk->id;
            } else if ($time >= $config_pulang->start && $time <= $config_pulang->end) {
                $type = $config_pulang->id;
            } else {
                $type = 0;
            }

            if (!empty($request->site_uid)) {
                $site_uid = $request->site_uid;
                $site = Site::where('uid', $site_uid)->first();
                $site_id = $site->id;
            }

            // $dataPhoto = null;
            // $photo = $request->file('photo');
            // if(!empty($photo)) {
            //     $dataPhoto = date('YmdHis') . '.' . $photo->extension();

            //     $destinationPath = public_path('images/attendances/');
            //     $photo->move($destinationPath, $dataPhoto);
            // }

            // Proses foto yang diambil dari input hidden 'photo'
            $dataPhoto = null;
            $photoUrl = null;
            if (!empty($request->photo)) {
                // Nama file dengan timestamp
                $dataPhoto = date('YmdHis') . '.png'; // Simpan sebagai file PNG
                $base64Photo = $request->photo;

                // Validasi apakah base64 memiliki prefix seperti 'data:image/png;base64,'
                if (preg_match('/^data:image\/(\w+);base64,/', $base64Photo, $type)) {
                    $data = substr($base64Photo, strpos($base64Photo, ',') + 1);
                    $type = strtolower($type[1]); // Dapatkan tipe gambar (jpeg, png, dll.)

                    if (!in_array($type, ['jpg', 'jpeg', 'png'])) {
                        throw new \Exception('Format gambar tidak didukung');
                    }

                    // Decode base64 dan simpan ke file
                    $data = base64_decode($data);

                    if ($data === false) {
                        throw new \Exception('Base64 decoding gagal');
                    }

                    // Tentukan path penyimpanan
                    $imagePath = 'images/attendances/' . $dataPhoto;

                    // Simpan file ke GCS menggunakan Storage::disk
                    Storage::disk('gcs')->put($imagePath, $data);

                    // URL publik untuk file yang diunggah
                    $photoUrl = Storage::disk('gcs')->url($imagePath);
                } else {
                    throw new \Exception('Foto tidak valid');
                }
            }

            if ($request->event_id == 1) {
                $attendance = AttendanceTemporary::create([
                    'employee_id' => auth()->user()->employee->id,
                    'state' => 1,
                    'timestamp' => $timestamp,
                    'type' => $type,
                    'event_id' => $request->event_id,
                    'site_id' => $site_id,
                    'longitude' => $request->longitude,
                    'latitude' => $request->latitude,
                    'keterangan' => $request->keterangan,
                    'photo' => $photoUrl
                ]);

                $input['description'] = $attendance->employee->user->name . ' melakukan absensi menggunakan tag lokasi dengan keterangan <b>' . $request->keterangan . '</b> mohon untuk melihat dan validasi absensi tersebut pada aplikasi <a href="https://ems.tpm-facility.com">https://ems.tpm-facility.com</a><br><br>Terima Kasih';
                $input['subject'] = $attendance->employee->user->name . ' Tag Location';

                $input['email'] = 'endro.setyantono@tpm-facility.com';
                $input['name'] = 'Endro Setyantono';
                // $input['email'] = 'ahmad.fatoni@mindotek.com';
                // $input['name'] = 'Ahmad Fatoni';

                // $input['cc'][] = 'endro.setyantono@tpm-facility.com';

                Mail::send('email.send_announcement', $input, function ($message) use ($input) {
                    $message->to($input['email'], $input['name'])->subject($input['subject']);
                });

                return redirect()->route('attendances.employee')->with('success', 'Absensi harus di validasi oleh HRD terlebih dahulu!');
            } else {
                $attendance = Attendance::create([
                    'employee_id' => auth()->user()->employee->id,
                    'state' => 1,
                    'timestamp' => $timestamp,
                    'type' => $type,
                    'event_id' => $request->event_id,
                    'site_id' => $site_id,
                    'longitude' => $request->longitude,
                    'latitude' => $request->latitude,
                    'keterangan' => $request->keterangan,
                    'photo' => $photoUrl
                ]);

                return redirect()->route('attendances.employee')->with('success', 'attendance created successfully');
            }
        } catch (\Exception $th) {
            return back()->with('error', $th);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function current_location(Request $request)
    {
        $currentUserInfo = Location::get($request->ip());
        return response()->json($currentUserInfo);
    }
}
