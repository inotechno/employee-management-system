<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CompareDistance;
use App\Helpers\FingerprintSDK;
use App\Models\Machine;
use App\Models\Attendance;
use Rats\Zkteco\Lib\ZKTeco;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Jobs\AttendanceSyncJob;
use App\Models\ConfigAttendance;
use App\Models\Employee;
use App\Models\EventAttendance;
use App\Models\Site;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $attendances = Attendance::with('employee', 'employee.user')->where('employee_id', '20221211')->first();
        // dd($attendances);

        return view('attendances.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('attendances.create');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $attendances = Attendance::select('*', DB::raw('DATE(timestamp) as date'))
                ->with('employee', 'employee.user')
                ->groupBy(['date', 'employee_id'])
                ->orderBy('timestamp', 'desc');

            // dd($attendances);

            if (!empty($request->employee_id)) {
                $attendances = $attendances->where('employee_id', $request->employee_id);
            }

            if (!empty($request->date)) {
                $attendances = $attendances->whereDate('timestamp', '=', $request->date);
            }

            $attendances->get();
            return DataTables::of($attendances)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    return '<a class="btn btn-warning btn-sm" href="' . route('attendances.edit', $row->id) . '">
                               <i class="bx bx-edit-alt" ></i>
                            </a>
                            <button class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '">
                               <i class="bx bx-trash"></i>
                            </button>';
                })

                ->addColumn('_in', function ($row) {
                    $data = '';
                    $in = '-';
                    // $out = '-';
                    $attendance = '';

                    $config_masuk = ConfigAttendance::find(1);
                    // $config_pulang = ConfigAttendance::find(2);

                    $in = Attendance::whereTime('timestamp', '<=', $config_masuk->end)->whereDate('timestamp', $row->date)->where('employee_id', $row->employee_id)->orderBy('timestamp', 'ASC')->first();
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

                        $detail = '<a href="#" class="badge fs-6 m-1 bg-primary btn-detail-in" data-keterangan="' . $in->keterangan . '" data-photo="' . $in->photo . '">Detail <span class="bx bxs-hand-up"></span></a>';
                        $attendance = '<span class="badge fs-6 m-1 text ' . $color_time . '">' . DATE('H:i', strtotime($in->timestamp)) . '</span>' . $span . ' ' . $location . ' ' . $detail;
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
                    $out = Attendance::whereTime('timestamp', '>=', $config_pulang->start)->whereDate('timestamp', $row->date)->where('employee_id', $row->employee_id)->orderBy('timestamp', 'DESC')->first();

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
                        $detail = '<a href="#" class="badge fs-6 m-1 bg-primary btn-detail-out" data-keterangan="' . $out->keterangan . '" data-photo="' . $out->photo . '">Detail <span class="bx bxs-hand-up"></span></a>';
                        $attendance = '<span class="badge fs-6 m-1 text ' . $color_time . '">' . DATE('H:i', strtotime($out->timestamp)) . '</span>' . $span . ' ' . $location . ' ' . $detail;
                    }

                    $data = $attendance;
                    return $data;
                })

                ->rawColumns(['_in', '_out'])
                ->make(true);
        }
    }

    public function sync()
    {

        // // $machine = Machine::where('active', 'yes')->first();
        // $this->zk = new ZKTeco('192.168.20.221', 80);
        // $this->zk->connect();
        // dd($this->zk->disconnect());
        // dd($this->zk->getAttendance());

        try {

            // dd($this->zk->getAttendance());
            // Melakukan pemanggilan sekali ke database
            $configurations = ConfigAttendance::whereIn('id', [1, 2])->select('id', 'start', 'end')->get()->keyBy('id');
            $siteId = 84;

            $fingerprintSDK = new FingerprintSDK();
            $getAttendance = $fingerprintSDK->getAttendance();
            // dd($getAttendance);

            $attendanceData = $this->prepareAttendanceData($getAttendance, $configurations, $siteId);
            $chunkedData = array_chunk($attendanceData, 1000); // Split data into chunks of 1000 records

            // Chunk the data to insert in smaller batches

            foreach ($chunkedData as $data) {
                AttendanceSyncJob::dispatch($data);
            }

            // AttendanceSyncJob::dispatch($chunkedData);

            // foreach ($chunkedData as $chunk) {
            // Attendance::insertOrIgnore($chunk);
            // foreach ($chunk as $data) {
            //     Attendance::updateOrCreate(
            //         ['uid' => $data['uid']],
            //         $data
            //     );
            // }
            // }

            $response = [
                'success' => true,
                'message' => 'Syncronize Success'
            ];
        } catch (\Throwable $th) {
            $response = [
                'success' => false,
                'message' => $th->getMessage()
            ];
        }

        return response()->json($response);
    }

    protected function prepareAttendanceData($data, $configurations, $siteId)
    {
        $attendanceData = [];
        foreach ($data as $attendance) {
            if ($attendance['PIN'] == 20221201) {
                continue;
            }

            $employeeId = $attendance['PIN'];
            $timestamp = $attendance['DateTime'];
            $time = date('H:i:s', strtotime($timestamp));

            $type = $this->getAttendanceType($time, $configurations);

            $attendanceData[] = [
                'uid' => $attendance['UID'],
                'employee_id' => $employeeId,
                'state' => $attendance['Verified'],
                'timestamp' => $timestamp,
                'type' => $type,
                'site_id' => $siteId,
                'event_id' => 3,
                'longitude' => '106.798818',
                'latitude' => '-6.263122'
            ];
        }
        return $attendanceData;
    }

    protected function getAttendanceType($time, $configurations)
    {
        $defaultType = 0;

        foreach ($configurations as $config) {
            if ($time >= $config->start && $time <= $config->end) {
                return $config->id;
            }
        }

        return $defaultType;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'employee_id'   => 'required',
            'timestamp'   => 'required',
        ]);

        $site_uid = 'DNevn0QTWnkLiFW';

        $config_masuk = ConfigAttendance::find(1);
        $config_pulang = ConfigAttendance::find(2);

        try {

            $time = date('H:i:s', strtotime($request->timestamp));
            if ($time >= $config_masuk->start && $time <= $config_masuk->end) {
                $type = $config_masuk->id;
            } else if ($time >= $config_pulang->start && $time <= $config_pulang->end) {
                $type = $config_pulang->id;
            } else {
                $type = 0;
            }

            if ($request->site_uid) {
                $site_uid = $request->site_uid;
            }

            $site_id = Site::where('uid', $site_uid)->first();

            $attendance = Attendance::create([
                'employee_id'   => $request->employee_id,
                'state'         => 1,
                'timestamp'     => $request->timestamp,
                'type'          => $type,
                'site_id'       => $site_id->id,
                'longitude'     => '106.798818',
                'latitude'      => '-6.263122',
                'event_id'      => 3
            ]);

            return redirect()->route('attendances')->with('success', 'attendance created successfully');
        } catch (\Exception $th) {
            return back()->with('error', 'attendance created failed');
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attendance = Attendance::with('employee', 'employee.user')->find($id);
        // dd($attendance);
        return view('attendances.edit', compact('attendance'));
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
        // dd($attendance);
        $attendance = Attendance::find($id);
        $validator = $request->validate([
            'timestamp'  => 'required',
        ]);

        $config_masuk = ConfigAttendance::find(1);
        $config_pulang = ConfigAttendance::find(2);

        $time = date('H:i:s', strtotime($request->timestamp));
        if ($time >= $config_masuk->start && $time <= $config_masuk->end) {
            $type = $config_masuk->id;
        } else if ($time >= $config_pulang->start && $time <= $config_pulang->end) {
            $type = $config_pulang->id;
        } else {
            $type = 0;
        }

        $validator['type'] = $type;
        try {
            $attendance->update($validator);
            return redirect()->route('attendances')->with('success', 'attendance updated successfully');
        } catch (\Throwable $th) {
            //throw $th;
            // dd($th);
            return back()->with('error', 'attendance updated failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attendance = Attendance::find($id);

        try {
            $attendance->delete();
            return redirect()->route('attendances')->with('success', 'Attendance deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Attendance deleted failed');
        }
    }
}
