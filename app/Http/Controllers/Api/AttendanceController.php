<?php

namespace App\Http\Controllers\Api;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AttendanceResource;
use App\Models\Site;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AttendanceController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendances = Attendance::orderBy('timestamp', 'desc')->get();
        return $this->sendResponse(AttendanceResource::collection($attendances), 'Attendances retrieved successfully');
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $this->sendResponse($request->all(), 'Attendances retrieved successfully');
        // die;
        $site_uid = 'DNevn0QTWnkLiFW';

        $validator = Validator::make($request->all(), [
            'employee_id'   => 'required',
            'state'         => 'required|numeric',
            'type'          => 'required|numeric',
            'longitude'     => 'required',
            'latitude'      => 'required',
            'keterangan'    => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Bad Parameter.', ['error' => $validator->errors()]);
        }

        if (!empty($request->site_uid)) {
            $site_uid = $request->site_uid;
        }

        $site = Site::where('uid', $site_uid)->first();

        try {
            $attendance = Attendance::create([
                'employee_id'   => $request->employee_id,
                'state'         => $request->state,
                'timestamp'     => date('Y-m-d H:i:s'),
                'type'          => $request->type,
                'event_id'      => $request->event_id,
                'site_id'       => $site->id,
                'longitude'     => $request->longitude,
                'latitude'      => $request->latitude,
                'keterangan'    => $request->keterangan,
            ]);

            return $this->sendResponse(new AttendanceResource($attendance), 'Attendances created successfully');
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
        $attendance = Attendance::find($id);

        if (is_null($attendance)) {
            return $this->sendError('Attendance not found.');
        }

        return $this->sendResponse(new AttendanceResource($attendance), 'Attendance retrieved successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function employee($id)
    {
        $attendances = Attendance::orderBy('timestamp', 'desc')->where('employee_id', $id)->get();

        if (is_null($attendances)) {
            return $this->sendError('Attendance not found.');
        }

        return $this->sendResponse(AttendanceResource::collection($attendances), 'Attendances retrieved successfully');
    }

    public function check_absen($id)
    {
        $masuk = Attendance::whereDate('timestamp', Carbon::today())->where('employee_id', $id)->where('type', 1)->get();
        $pulang = Attendance::whereDate('timestamp', Carbon::today())->where('employee_id', $id)->where('type', 2)->get();
        // $belum_masuk = [];

        if ($masuk->first()) {
            if ($pulang->first()) {
                return $this->sendResponse(AttendanceResource::collection($pulang), 'Attendances retrieved successfully');
            }
            return $this->sendResponse(AttendanceResource::collection($masuk), 'Attendances retrieved successfully');
        } else {
            $belum_masuk = collect([
                [
                    "id" => 0,
                    "employee_id" => $id,
                    "name" => '0',
                    "state" => 0,
                    "timestamp" => '0',
                    "type" => 0,
                    "created_at" => '0',
                    "updated_at" => '0'
                ],
            ]);

            return $this->sendResponse($belum_masuk, 'Attendances retrieved successfully');
        }
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
        $attendance = Attendance::find($id);

        if (is_null($attendance)) {
            return $this->sendError('Attendance not found.');
        }

        $validator = Validator::make($request->all(), [
            'employee_id'   => 'required',
            'state'         => 'required|numeric',
            'timestamp'     => 'required',
            'type'          => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Bad Parameter.', ['error' => $validator->errors()]);
        }

        try {
            $attendance->update([
                'employee_id'   => $request->employee_id,
                'state'         => $request->state,
                'timestamp'     => $request->timestamp,
                'type'          => $request->type,
            ]);

            return $this->sendResponse(new AttendanceResource($attendance), 'Attendances created successfully');
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
        $attendance = Attendance::find($id);

        try {
            $attendance->delete();
            return $this->sendResponse(new AttendanceResource($attendance), 'Paid leave deleted successfully');
        } catch (\Exception $th) {
            return $this->sendError('Failed', ['error' => $th->getMessage()]);
        }
    }

}
