<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\DailyReport;
use App\Models\Employee;
use App\Models\PaidLeave;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $attendances = Attendance::where('employee_id', auth()->user()->employee->id)->count();
        $daily_report = DailyReport::where('employee_id', auth()->user()->employee->id)->count();
        $paid_leave = PaidLeave::where('employee_id', auth()->user()->employee->id)->count();
        $employee = Employee::where('id', auth()->user()->employee->id)->first();

        return view('dashboard', compact('attendances', 'daily_report', 'paid_leave', 'employee'));
    }
}
