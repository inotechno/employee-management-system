<?php

namespace App\Http\Controllers\Api;

use App\Models\Absent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AbsentResource;
use Illuminate\Support\Facades\Validator;

class AbsentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $absents = Absent::orderBy('created_at', 'desc')->get();
        return $this->sendResponse(AbsentResource::collection($absents), 'Absent retrieved successfully');
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

    public function employee($id)
    {
        $paid_leaves = Absent::orderBy('created_at', 'desc')->where('employee_id', $id)->get();
        return $this->sendResponse(AbsentResource::collection($paid_leaves), 'Absent retrieved successfully');
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
            'date'  => 'required|date|after_or_equal:' . date('Y-m-d'),
            'description'    => 'required|min:10',
            'employee_id'    => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Bad Parameter.', ['error' => $validator->errors()]);
        }

        try {
            $absent = Absent::create([
                'employee_id'   => $request->employee_id,
                'date'          => $request->date,
                'description'   => $request->description,
            ]);
            return $this->sendResponse($absent, 'Absent created successfully');
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
        $absent = Absent::find($id);

        if (is_null($absent)) {
            return $this->sendError('Absent not found.');
        }

        return $this->sendResponse(new AbsentResource($absent), 'Absent retrieved successfully');
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
        $absent = Absent::find($id);

        $validator = Validator::make($request->all(), [
            'tanggal_mulai'  => 'required|date|before_or_equal:tanggal_akhir|after:' . date('Y-m-d'),
            'tanggal_akhir'  => 'required|date|after_or_equal:tanggal_mulai',
            'description'    => 'required|min:10',
            'employee_id'    => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Bad Parameter.', ['error' => $validator->errors()]);
        }

        if ($absent->status == 1) {
            return $this->sendError('Absent cannot be updated');
        }

        try {
            $absent->update([
                'employee_id'   => $request->employee_id,
                'date' => $request->date,
                'description'   => $request->description,
            ]);

            return $this->sendResponse(new AbsentResource($absent), 'Absent created successfully');
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
        $paid_leave = Absent::find($id);

        if (is_null($paid_leave)) {
            return $this->sendError('Absent not found.');
        }

        try {
            if ($paid_leave->status == 2) {
                return $this->sendError('Absent cannot be deleted');
            }

            $paid_leave->delete();
            return $this->sendResponse(new AbsentResource($paid_leave), 'Absent deleted successfully');
        } catch (\Exception $th) {
            return $this->sendError('Failed', ['error' => $th->getMessage()]);
        }
    }
}
