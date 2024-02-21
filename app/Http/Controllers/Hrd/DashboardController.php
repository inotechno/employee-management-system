<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\PaidLeave;
use App\Models\Position;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $attendances = Attendance::all()->count();
        $employees = Employee::where('status', 1)->get()->count();
        $positions = Position::all()->count();
        $paid_leave = PaidLeave::all()->count();

        return view('dashboard', compact('employees', 'positions', 'paid_leave', 'attendances'));
    }
}
