<?php

namespace App\Http\Controllers\Director;

use App\Models\Site;
use App\Models\Visit;
use App\Models\Employee;
use App\Models\Position;
use App\Models\PaidLeave;
use App\Models\Attendance;
use App\Models\DailyReport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Absent;
use App\Models\Reminder;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;

class DashboardController extends Controller
{
    public function index()
    {
        $yesterday          = Carbon::now()->subDay()->format('Y-m-d');
        // $yesterday = '2023-09-29';
        $employees          = Employee::where('status', 1)->get()->count();
        $attendances        = Attendance::whereDate('timestamp', $yesterday)->where('type', 1)->groupBy('employee_id')->get()->count();
        $attendances        = Attendance::whereDate('timestamp', $yesterday)->where('type', 1)->groupBy('employee_id')->get()->count();
        $daily_report       = DailyReport::whereDate('date', $yesterday)->count();
        $ijin               = Absent::whereDate('date', $yesterday)->count();
        // $paid_leave      = PaidLeave::whereDate('created_at', $yesterday)->groupBy('employee_id')->count();
        $paid_leave         = PaidLeave::where(function ($query) use ($yesterday) {
            $query->whereBetween('tanggal_mulai', [$yesterday, $yesterday])
                ->orWhereBetween('tanggal_akhir', [$yesterday, $yesterday]);
        })->count();

        $absent = Employee::whereDoesntHave('attendance', function ($query) use ($yesterday) {
            $query->whereDate('timestamp', $yesterday);
        })->whereDoesntHave('paid_leave', function ($query) use ($yesterday) {
            $query->whereDate('tanggal_mulai', '<=', $yesterday)
                ->whereDate('tanggal_akhir', '>=', $yesterday);
        })->whereDoesntHave('absent', function ($query) use ($yesterday) {
            $query->whereDate('date', $yesterday);
        })->where('status', 1)->count();

        // dd($absent);
        $site = Site::all()->count();
        $visit = Visit::whereDate('created_at', $yesterday)->where('status', 1)->groupBy('employee_id')->get()->count();

        $presences = Employee::select('user_id', 'id', 'position_id')->with('position')->with('user', function ($query) {
            return $query->select('id', 'name', 'foto');
        })->whereHas('attendance', function ($query) {
            return $query->whereYear('timestamp', date('Y'));
        })->where('status', 1)->groupBy('id')->get();

        $total_visits = Visit::select('employee_id', DB::raw('COUNT(id) as total'))->with('employee', 'employee.user')->whereYear('created_at', date('Y'))->groupBy('employee_id', DB::raw('DATE(created_at)'))->orderBy('total', 'desc')->limit(5)->get();
        $total_visit_sites = Visit::select('site_id', DB::raw('COUNT(id) as total'))->with('site')->whereYear('created_at', date('Y'))->groupBy('site_id', DB::raw('DATE(created_at)'))->limit(5)->orderBy('total', 'desc')->get();

        $reminders = Reminder::with('employee', 'employee.user')->whereDate('date', $yesterday)->orderBy('created_at', 'desc')->limit(10)->get();

        $best_presences = Attendance::select('employee_id', DB::raw('COUNT(id) as total, DATE(timestamp) as date'))->with('employee', 'employee.user', 'employee.position')->whereYear('timestamp', date('Y'))->whereTime('timestamp', '<=', '08:30:00')->groupBy('employee_id')->orderBy('total', 'desc')->limit(6)->get();

        return view('dashboard', compact(
            'yesterday',
            'employees',
            'attendances',
            'daily_report',
            'paid_leave',
            'site',
            'visit',
            'best_presences',
            'total_visits',
            'total_visit_sites',
            'absent',
            'ijin',
            'reminders'
        ));
    }

    function selisih_hari($start_date, $end_date)
    {
        $total_hari = 0;
        $period = new DatePeriod(
            new DateTime($start_date),
            new DateInterval('P1D'),
            new DateTime(date('Y-m-d', strtotime('+1 day', strtotime($end_date))))
        );

        foreach ($period as $period) {
            $date = $period->format('Ymd');
            $array = json_decode(file_get_contents("https://raw.githubusercontent.com/guangrei/Json-Indonesia-holidays/master/calendar.json"), true);

            if (isset($array[$date])) {
                //jika tanggal merah berdasarkan libur nasional
            } else if (date("D", strtotime($date)) === "Sun") {
                //jika Hari Minggu
            } else if (date("D", strtotime($date)) === "Sat") {
                //jika Hari Sabtu
            } else {
                //jika Bukan Tanggal Merah dan Libur Nasional
                $total_hari++;
            }
        }

        return $total_hari;
    }
}
