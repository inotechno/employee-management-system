<?php

namespace App\Http\Controllers\Director;

use App\Models\Visit;
use Illuminate\Http\Request;
use App\Helpers\CompareDistance;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VisitController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->date;
        return view('_director.visits.index', compact('date'));
    }

    public function employee()
    {
        return view('_director.visits.employee');
    }

    public function site()
    {
        $sites = Site::all();
        return view('_director.visits.site', compact('sites'));
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $visits = Visit::select('*', DB::raw('DATE(created_at) as date'))
                ->with('employee', 'site', 'employee.user', 'category')
                ->groupBy(['date', 'employee_id', 'site_id'])
                ->orderBy('created_at', 'DESC');

            if (!empty($request->employee_id)) {
                $visits = $visits->where('employee_id', $request->employee_id);
            }
            if (!empty($request->date)) {
                $visits = $visits->whereDate('created_at', $request->date);
            }

            $visits->get();
            return DataTables::of($visits)
                ->addColumn('_in', function ($row) {
                    $data = '';
                    $visit = '';

                    if ($row->site_id != NULL) {
                        $in = Visit::where('status', 0)
                            ->where('site_id', $row->site_id)
                            ->whereDate('created_at', $row->date)
                            ->where('employee_id', $row->employee_id)
                            ->first();
                    } else {
                        $in = Visit::where('status', 0)
                            ->where('site_id', NULL)
                            ->whereDate('created_at', $row->date)
                            ->where('employee_id', $row->employee_id)
                            ->first();
                    }

                    if ($in) {
                        $span = '';
                        $color = "bg-success";
                        $distance = 0;
                        $unit = "m";
                        $color_time = 'bg-secondary';
                        $location = '';

                        if ($in->site_id != NULL) {
                            $site_name = '<span class="badge fs-6 m-1 text bg-info">' . $in->site->name . '</span>';
                            $compare = CompareDistance::getDistance($in->latitude, $in->longitude, $in->site->latitude, $in->site->longitude);
                        } else {
                            $site = Site::find(84);
                            $site_name = '<span class="badge fs-6 m-1 text bg-danger">Tidak ada site</span>';
                            $compare = CompareDistance::getDistance($in->latitude, $in->longitude, $site->latitude, $site->longitude);
                        }

                        $distance = $compare['meters'];
                        $location = '<a class="badge fs-6 text bg-secondary" href ="http://maps.google.com/maps?q=' . $in->latitude . ',' . $in->longitude . '" target="_blank">Location <i class="bx bx-link-external"></i></a>';

                        if ($distance > 1000) {
                            $distance = $compare['kilometers'];
                            $unit = 'Km';
                            $color = 'bg-danger';
                        } else if ($distance > 100) {
                            $color = 'bg-warning';
                        }

                        $detail = '<a href="#" class="badge fs-6 m-1 bg-primary btn-detail-in" data-keterangan="' . $in->keterangan . '" data-file="' . asset('images/visits/' . $in->file) . '">Detail <span class="bx bxs-hand-up"></span></a>';
                        $span = $site_name . '<span class="badge fs-6 m-1 text ' . $color . ' ">Distance : ' . intval($distance) . ' ' . $unit . '</span>';
                        $visit = '<span class="badge fs-6 m-1 text ' . $color_time . '">' . DATE('H:i', strtotime($in->created_at)) . '</span>' . $span . ' ' . $location . ' ' . $detail;
                    }

                    $data = $visit;
                    return $data;
                })

                ->addColumn('_out', function ($row) {
                    $data = '';
                    $visit = '';

                    if ($row->site_id != NULL) {
                        $out = Visit::where('status', 1)
                            ->where('site_id', $row->site_id)
                            ->whereDate('created_at', $row->date)
                            ->where('employee_id', $row->employee_id)
                            ->first();
                    } else {
                        $out = Visit::where('status', 1)
                            ->where('site_id', NULL)
                            ->whereDate('created_at', $row->date)
                            ->where('employee_id', $row->employee_id)
                            ->first();
                    }

                    if ($out) {
                        $span = '';
                        $color = "bg-success";
                        $distance = 0;
                        $unit = "m";
                        $color_time = 'bg-secondary';
                        $location = '';

                        if ($out->site_id != NULL) {
                            $site_name = '<span class="badge fs-6 m-1 text bg-info">' . $out->site->name . '</span>';
                            $compare = CompareDistance::getDistance($out->latitude, $out->longitude, $out->site->latitude, $out->site->longitude);
                        } else {
                            $site = Site::find(84);

                            $site_name = '<span class="badge fs-6 m-1 text bg-danger">Tidak ada site</span>';
                            $compare = CompareDistance::getDistance($out->latitude, $out->longitude, $site->latitude, $site->longitude);
                        }

                        $distance = $compare['meters'];
                        $location = '<a class="badge fs-6 text bg-secondary" href ="http://maps.google.com/maps?q=' . $out->latitude . ',' . $out->longitude . '" target="_blank">Location <i class="bx bx-link-external"></i></a>';

                        if ($distance > 1000) {
                            $distance = $compare['kilometers'];
                            $unit = 'Km';
                            $color = 'bg-danger';
                        } else if ($distance > 100) {
                            $color = 'bg-warning';
                        }

                        $detail = '<a href="#" class="badge fs-6 m-1 bg-primary btn-detail-out" data-keterangan="' . $out->keterangan . '"  data-file="' . asset('images/visits/' . $out->file) . '">Detail <span class="bx bxs-hand-up"></span></a>';
                        $span = $site_name . '<span class="badge fs-6 m-1 text ' . $color . ' ">Distance : ' . intval($distance) . ' ' . $unit . '</span>';
                        $visit = '<span class="badge fs-6 m-1 text ' . $color_time . '">' . DATE('H:i', strtotime($out->created_at)) . '</span>' . $span . ' ' . $location . ' ' . $detail;
                    }

                    $data = $visit;
                    return $data;
                })

                ->rawColumns(['_in', '_out'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function datatable_employees(Request $request)
    {
        if ($request->ajax()) {
            $visits = Visit::select('employee_id', DB::raw('COUNT(id) as total, MONTH(created_at) as month, YEAR(created_at) as year'))
                ->with('employee', 'employee.user', 'employee.position')
                ->where('status', 0)
                ->whereYear('created_at', date('Y'))
                ->groupBy('employee_id')
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->orderBy('month', 'desc');

            // dd($visits->get());
            if (!empty($request->employee_id)) {
                $visits = $visits->where('employee_id', $request->employee_id);
            }

            if (!empty($request->month)) {
                $visits = $visits->whereMonth('created_at', date('m', strtotime($request->month)));
                $visits = $visits->whereYear('created_at', date('Y', strtotime($request->month)));
            }

            $visits->get();

            return DataTables::of($visits)
                ->addColumn('position_name', function ($row) {
                    $position = 'Tidak ada';
                    if (!empty($row->position)) {
                        $position =  $row->position->name;
                    }

                    return $position;
                })
                ->addColumn('periode', function ($row) {
                    $month = Carbon::create()->month($row->month)->isoFormat('MMMM');
                    return $month . ' ' . $row->year;
                })
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-info btn-sm btn-detail" data-employee_id="' . $row->employee_id . '" data-name="' . $row->employee->user->name . '" data-month="' . $row->month . '" data-year="' . $row->year . '">
                               <i class="bx bx-detail"></i> Detail
                            </button>';
                })
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function datatable_sites(Request $request)
    {
        if ($request->ajax()) {
            $visits = Visit::select('site_id', DB::raw('COUNT(id) as total, MONTH(created_at) as month, YEAR(created_at) as year'))
                ->where('status', 0)
                ->with('site')
                ->whereYear('created_at', date('Y'))
                ->groupBy('site_id', DB::raw('MONTH(created_at)'))
                ->limit(5)
                ->orderBy('month', 'desc');

            // dd($visits->get());
            if (!empty($request->site_id)) {
                $visits = $visits->where('site_id', $request->site_id);
            }

            if (!empty($request->month)) {
                $visits = $visits->whereMonth('created_at', date('m', strtotime($request->month)));
                $visits = $visits->whereYear('created_at', date('Y', strtotime($request->month)));
            }

            $visits->get();

            return DataTables::of($visits)

                ->addColumn('periode', function ($row) {
                    $month = Carbon::create()->month($row->month)->isoFormat('MMMM');
                    return $month . ' ' . $row->year;
                })
                ->addColumn('coordinate', function ($row) {
                    return 'Lat: ' . $row->site->latitude . ', Long: ' . $row->site->longitude;
                })
                ->addColumn('action', function ($row) {
                    $button = '';
                    $button .= '<button class="btn btn-info btn-sm btn-detail" data-site_id="' . $row->site_id . '" data-name="' . $row->site->name . '" data-month="' . $row->month . '" data-year="' . $row->year . '">
                               <i class="bx bx-detail"></i> Detail
                            </button>';
                    return $button;
                })
                ->addIndexColumn()
                ->rawColumns(['coordinate', 'action'])
                ->make(true);
        }
    }

    public function detail(Request $request)
    {
        if ($request->ajax()) {

            $visits = Visit::with('site', 'employee', 'employee.user')->where('status', 0)->whereMonth('created_at', $request->month)->whereYear('created_at', $request->year);

            // dd($visits->get());
            if (!empty($request->site_id)) {
                $visits = $visits->where('site_id', $request->site_id);
            }

            if (!empty($request->employee_id)) {
                $visits = $visits->where('employee_id', $request->employee_id);
            }

            $visits->get();

            return DataTables::of($visits)

                ->addColumn('date', function ($row) {
                    return Carbon::parse(date('Y-m-d H:i', strtotime($row->created_at)))->isoFormat('LLLL');
                })
                ->addIndexColumn()
                ->make(true);
        }
    }
}
