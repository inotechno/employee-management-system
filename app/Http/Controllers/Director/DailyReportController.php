<?php

namespace App\Http\Controllers\Director;

use App\Models\Comment;
use App\Models\DailyReport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DailyReportController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->date;
        return view('_director.daily_reports.index', compact('date'));
    }

    public function datatable(Request $request)
    {
        // dd($request);
        if ($request->ajax()) {
            $user = Auth::user();
            if ($user->hasRole('director')) {
                $dailyreport = DailyReport::with('employee', 'employee.user')->orderBy('created_at', 'DESC');
            } else {
                $dailyreport = DailyReport::with('employee', 'employee.user')->whereHas('users', function ($query) {
                    return $query->where('user_id', Auth::user()->id);
                })->orderBy('created_at', 'DESC');
            }

            if (!empty($request->employee_id)) {
                $dailyreport = $dailyreport->where('employee_id', $request->employee_id);
            }

            if (!empty($request->date)) {
                $dailyreport = $dailyreport->whereDate('date', $request->date);
            }

            $dailyreport->get();

            // dd($attendances);
            return DataTables::of($dailyreport)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a class="btn btn-info btn-sm" href="' . route('daily_reports.show.all', $row->id) . '">
                               <i class="bx bx-show" ></i>
                            </a>';
                })
                ->addColumn('_description', function ($row) {
                    return Str::limit($row->description, 50);
                })
                ->addColumn('_status', function ($row) {
                    if ($row->seen_at != NULL)
                        return '<span class="badge bg-info">Dibaca</span>';

                    return '<span class="badge bg-warning">Belum dibaca</span>';
                })
                ->rawColumns(['action', '_description', '_status'])
                ->make(true);
        }
    }

    public function show($id)
    {
        $daily_report = DailyReport::find($id);
        $daily_report->update(['seen_at' => date('Y-m-d H:i:s')]);
        $daily_report->comment()->update(['seen_at' => date('Y-m-d H:i:s')]);
        return view('_director.daily_reports.show', compact('daily_report'));
    }

    public function store(Request $request, $id)
    {
        // dd($id);
        $daily_reports = Comment::where('daily_report_id', $id);
        // dd($daily_reports);
        $daily_reports->update([
            'seen_at' => date('Y-m-d H:i:s')
        ]);

        Comment::create([
            'daily_report_id' => $id,
            'user_id'         => auth()->id(),
            'comment'         => $request->comment,
        ]);

        return redirect()->back();
    }
}
