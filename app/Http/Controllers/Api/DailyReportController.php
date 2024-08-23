<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use App\Models\DailyReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\DailyReportResource;
use App\Http\Controllers\Api\BaseController;

class DailyReportController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $daily_reports = DailyReport::orderBy('date', 'desc')->get();
        return $this->sendResponse(DailyReportResource::collection($daily_reports), 'Daily reports retrieved successfully');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function daily_report_employees(Request $request)
    {
        // dd($request);
        $daily_reports = DailyReport::with('employee', 'employee.user')->whereHas('users', function ($query) use ($request) {
            return $query->where('user_id', $request->user_id);
        })->orderBy('created_at', 'DESC')->get();

        if (is_null($daily_reports)) {
            return $this->sendError('Daily report not found.');
        }

        return $this->sendResponse(DailyReportResource::collection($daily_reports), 'Daily reports retrieved successfully');
    }

    public function employee($id)
    {
        $daily_reports = DailyReport::with('comment', 'comment.user')->with('users', function ($q) {
            return $q->select('name');
        })->orderBy('created_at', 'desc')->where('employee_id', $id)->whereMonth('date', date('m'))->get();

        if (is_null($daily_reports)) {
            return $this->sendError('Daily report not found.');
        }

        return $this->sendResponse(DailyReportResource::collection($daily_reports), 'Daily reports retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id'   => 'required',
            'date'          => 'required|date|after_or_equal:yesterday|before:tomorrow',
            'description'   => 'required|min:10',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Bad Parameter.', ['error' => $validator->errors()]);
        }

        $employee  = Employee::find($request->employee_id);
        $request['from'] = $employee->user->email;
        $request['name'] = $employee->user->name;

        try {
            $daily_report = DailyReport::create([
                'employee_id'   => $request->employee_id,
                'date'          => $request->date,
                'day'           => intval(date('d', strtotime($request->date))),
                'description'   => $request->description,
                'cc'            => $request->cc,
            ]);

            if (!empty($request->cc)) {
                $daily_report->users()->sync($request->cc);
                // Mail::cc($request->cc)->to($request['from'])->send(new DailyReportMail($request));
                // $validator['cc'] = implode(',', $request->cc);
            }

            return $this->sendResponse(new DailyReportResource($daily_report), 'Daily report created successfully');
        } catch (\Exception $th) {
            return $this->sendError('Failed', ['error' => $th->getMessage()]);
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
        $daily_report = DailyReport::with('comment', 'comment.user')->find($id);

        if (is_null($daily_report)) {
            return $this->sendError('Daily report not found.');
        }

        return $this->sendResponse(new DailyReportResource($daily_report), 'Daily report retrieved successfully');
    }

    public function last($employee_id)
    {
        $daily_report = DailyReport::where('employee_id', $employee_id)->latest()->first();

        if (is_null($daily_report)) {
            return $this->sendError('Daily report not found.');
        }

        return $this->sendResponse(new DailyReportResource($daily_report), 'Daily report retrieved successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
        $daily_report = DailyReport::find($id);

        if (is_null($daily_report)) {
            return $this->sendError('Daily report not found.');
        }

        $validator = Validator::make($request->all(), [
            'employee_id'   => 'required',
            'date'          => 'required|date',
            'description'   => 'required|min:10',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Bad Parameter.', ['error' => $validator->errors()]);
        }

        try {
            $daily_report->update([
                'employee_id'   => $request->employee_id,
                'date'          => $request->date,
                'description'   => $request->description,
            ]);

            return $this->sendResponse(new DailyReportResource($daily_report), 'Daily report created successfully');
        } catch (\Exception $th) {
            return $this->sendError('Failed', ['error' => $th->getMessage()]);
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

        if (is_null($daily_report)) {
            return $this->sendError('Daily report not found.');
        }

        try {
            $daily_report->delete();
            return $this->sendResponse(new DailyReportResource($daily_report), 'Daily report deleted successfully');
        } catch (\Exception $th) {
            return $this->sendError('Failed', ['error' => $th->getMessage()]);
        }
    }
}
