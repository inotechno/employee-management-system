<?php

namespace App\Http\Controllers\Hrd;

use App\Models\DailyReport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class DailyReportController extends Controller
{
    public function index()
    {
        return view('_hrd.daily_reports.index');
    }

    public function datatable(Request $request)
    {
        // dd($request);
        if ($request->ajax()) {
            $dailyreport = DailyReport::with('employee', 'employee.user');

            // dd($attendances);
            return DataTables::eloquent($dailyreport)
                ->addIndexColumn()
                ->addColumn('_description', function ($row) {
                    return Str::limit($row->description, 50);
                })
                ->addColumn('action', function ($row) {
                    return '<a class="btn btn-info btn-sm" href="' . route('daily_reports.show.hrd', $row->id) . '">
                               <i class="bx bx-show" ></i>
                            </a>';
                })
                ->rawColumns(['action', '_description'])
                ->make(true);
        }
    }

    public function show($id)
    {
        $daily_report = DailyReport::find($id);
        return view('_hrd.daily_reports.show', compact('daily_report'));
    }
}
