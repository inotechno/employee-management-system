<?php

namespace App\Http\Controllers\Finance;

use App\Models\DailyReport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class DailyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('_finance.daily_reports.index');
    }

    public function datatable(Request $request)
    {
        // dd($request);
        if ($request->ajax()) {
            // $store = Store::where('user_id', auth()->user()->id)->first();
            $attendances = DailyReport::orderBy('date', 'desc')->with('employee', 'employee.user');
            // dd($attendances);
            return DataTables::eloquent($attendances)
                ->addIndexColumn()
                // ->filter(function ($instance) use ($request) {
                //     if (!empty($request->get('date'))) {
                //         return $instance->collection = $instance
                //             ->whereDate('date', $request->get('date'));
                //     }
                // })
                ->addColumn('_description', function ($row) {
                    return Str::limit($row->description, 50);
                })
                ->addColumn('action', function ($row) {
                    return '<a class="btn btn-info btn-sm" href="' . route('daily_reports.show.finance', $row->id) . '">
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
        $daily_report->seen_at = date('Y-m-d H:i:s');
        $daily_report->save();
        return view('_finance.daily_reports.show', compact('daily_report'));
    }
}
