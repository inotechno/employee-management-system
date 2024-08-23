<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\DailyReport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Reminder;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->date;
        return view('reminders.index', compact('date'));
    }

    public function datatable(Request $request)
    {
        // dd($request);
        if ($request->ajax()) {
            $reminders = Reminder::with('employee', 'employee.user')
                ->orderBy('date', 'desc');

            // $reminders = Attendance::orderBy('timestamp', 'desc')->with('employee', 'employee.user')->orderBy('timestamp', 'desc');
            if (!empty($request->employee_id)) {
                $reminders = $reminders->where('employee_id', $request->employee_id);
            }

            if (!empty($request->date)) {
                $reminders = $reminders->whereDate('date', $request->date);
            }

            $reminders->get();

            // dd($attendances);
            return DataTables::of($reminders)
                ->addIndexColumn()
                ->make(true);
        }
    }
}
