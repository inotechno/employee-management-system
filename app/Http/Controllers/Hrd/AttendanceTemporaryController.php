<?php

namespace App\Http\Controllers\Hrd;

use App\Helpers\CompareDistance;
use App\Models\Machine;
use App\Models\Attendance;
use Rats\Zkteco\Lib\ZKTeco;
use Illuminate\Http\Request;
use App\Models\ConfigAttendance;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\AttendanceTemporary;
use App\Models\Site;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceTemporaryController extends Controller
{
    function __construct()
    {
        // $machine = Machine::where('active', 'yes')->first();
        // $this->zk = new ZKTeco($machine->ip);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('_hrd.attendances-temporary.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $attendances = AttendanceTemporary::select('*', DB::raw('DATE(timestamp) as date'))
                ->with('employee', 'employee.user')
                ->where('user_id',  null)
                ->groupBy(['date', 'employee_id'])
                ->orderBy('timestamp', 'desc');

            // $attendances = AttendanceTemporary::orderBy('timestamp', 'desc')->with('employee', 'employee.user');
            if (!empty($request->employee_id)) {
                $attendances = $attendances->where('employee_id', $request->employee_id);
            }

            if (!empty($request->date)) {
                $attendances = $attendances->whereDate('timestamp', '=', $request->date);
            }
            $attendances->get();
            return DataTables::of($attendances)
                ->addIndexColumn()
                ->addColumn('_in', function ($row) {
                    $data = '';
                    $in = '-';
                    // $out = '-';
                    $attendance = '';

                    $config_masuk = ConfigAttendance::find(1);
                    // $config_pulang = ConfigAttendance::find(2);

                    $in = AttendanceTemporary::whereTime('timestamp', '<=', $config_masuk->end)->whereDate('timestamp', $row->date)->where('employee_id', $row->employee_id)->orderBy('timestamp', 'ASC')->first();
                    // $out = AttendanceTemporary::whereTime('timestamp', '>=', $config_pulang->start)->whereDate('timestamp', $row->date)->where('employee_id', $row->employee_id)->latest()->first();

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

                        $detail = '<a href="#" class="badge fs-6 m-1 bg-primary btn-detail-in" data-keterangan="' . $in->keterangan . '" data-photo="' . asset('images/attendances/' . $in->photo) . '">Detail <span class="bx bxs-hand-up"></span></a>';
                        $attendance = '<span class="badge fs-6 m-1 text ' . $color_time . '">' . DATE('H:i', strtotime($in->timestamp)) . '</span>' . $span . ' ' . $location . ' ' . $detail .
                            '<button type="button" class="btn btn-primary btn-sm waves-effect waves-light btn-validation" data-id="' . $in->id . '"><i class="bx bx-check-double align-middle me-2"></i>Validasi</button>';
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

                    // $out = AttendanceTemporary::whereTime('timestamp', '<=', $config_masuk->end)->whereDate('timestamp', $row->date)->where('employee_id', $row->employee_id)->oldest()->first();
                    $out = AttendanceTemporary::whereTime('timestamp', '>=', $config_pulang->start)->whereDate('timestamp', $row->date)->where('employee_id', $row->employee_id)->orderBy('timestamp', 'DESC')->first();

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
                        $detail = '<a href="#" class="badge fs-6 m-1 bg-primary btn-detail-out" data-keterangan="' . $out->keterangan . '" data-photo="' . asset('images/attendances/' . $out->photo) . '">Detail <span class="bx bxs-hand-up"></span></a>';
                        $attendance = '<span class="badge fs-6 m-1 text ' . $color_time . '">' . DATE('H:i', strtotime($out->timestamp)) . '</span>' . $span . ' ' . $location . ' ' . $detail .
                            '<button type="button" class="btn btn-primary btn-sm waves-effect waves-light btn-validation" data-id="' . $out->id . '"><i class="bx bx-check-double align-middle me-2"></i>Validasi</button>';
                    }

                    $data = $attendance;
                    return $data;
                })

                ->rawColumns(['_in', '_out'])
                ->make(true);
        }
    }

    public function validation($id)
    {
        try {
            $attendance = AttendanceTemporary::find($id);
            $attendance->update(
                [
                    'user_id' => Auth::id()
                ]
            );
            Attendance::create($attendance->toArray());

            return redirect()->route('attendances.temporary.hrd')->with('success', 'attendance tag validation successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('attendances.temporary.hrd')->with('error', $th->getMessage());
        }
    }
}
