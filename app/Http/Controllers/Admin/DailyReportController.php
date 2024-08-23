<?php

namespace App\Http\Controllers\Admin;

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
        return view('daily_reports.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('daily_reports.create');
    }

    public function datatable(Request $request)
    {
        // dd($request);
        if ($request->ajax()) {
            $dailyreport = DailyReport::with('employee', 'employee.user')->orderBy('created_at', 'DESC');

            if (!empty($request->employee_id)) {
                $dailyreport = $dailyreport->where('employee_id', $request->employee_id);
            }

            if (!empty($request->date)) {
                $dailyreport = $dailyreport->whereDate('date', $request->date);
            }

            $dailyreport->get();

            return DataTables::of($dailyreport)
                ->addIndexColumn()

                ->addColumn('_description', function ($row) {
                    return Str::limit($row->description, 50);
                })
                ->addColumn('action', function ($row) {
                    return '<a class="btn btn-info btn-sm" href="' . route('daily_reports.show', $row->id) . '">
                               <i class="bx bx-show" ></i>
                            </a>
                            <a class="btn btn-warning btn-sm" href="' . route('daily_reports.edit', $row->id) . '">
                               <i class="bx bx-edit-alt" ></i>
                            </a>
                            <button class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '">
                               <i class="bx bx-trash"></i>
                            </button>';
                })
                ->rawColumns(['action', '_description'])
                ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $validator = $request->validate([
            'date'          => 'required|date',
            'description'   => 'required|min:10',
        ]);

        $validator['employee_id'] = auth()->user()->employee->id;

        try {
            DailyReport::create($validator);
            return redirect()->route('daily_reports')->with('success', 'Daily report added successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Daily report added failed');
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
        $daily_report = DailyReport::find($id);
        $daily_report->update(['seen_at' => date('Y-m-d H:i:s')]);
        return view('daily_reports.show', compact('daily_report'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $daily_report = DailyReport::find($id);
        // dd($daily_report);
        return view('daily_reports.edit', compact('daily_report'));
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
        // dd($request);
        $daily_report = DailyReport::find($id);

        $validator = $request->validate([
            'date'          => 'required|date',
            'description'   => 'required|min:10',
        ]);

        try {
            $daily_report->update($validator);
            return redirect()->route('daily_reports')->with('success', 'Daily report updated successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Daily report updated failed');
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
        $daily_report = DailyReport::find($id);

        try {
            $daily_report->delete();
            return redirect()->route('daily_reports')->with('success', 'Daily report deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Daily report deleted failed');
        }
    }
}
