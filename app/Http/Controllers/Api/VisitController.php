<?php

namespace App\Http\Controllers\Api;

use App\Models\Visit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\VisitResource;
use App\Models\Site;
use Illuminate\Support\Facades\Validator;

class VisitController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visits = Visit::orderBy('created_at', 'desc')->limit(20)->get();
        return $this->sendResponse(VisitResource::collection($visits), 'Visits retrieved successfully');
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
        // dd($request);
        // die;
        $validator = Validator::make($request->all(), [
            'employee_id'           => 'required',
            'uid'                   => 'required',
            'visit_category_id'     => 'required',
            'keterangan'            => 'required',
            'longitude'             => 'required',
            'latitude'              => 'required',
            'status'                => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Bad Parameter.', ['error' => $validator->errors()]);
        }

        try {
            $status = 0;
            $site_id = NULL;

            if ($request->uid != "" || $request->uid != NULL) {
                $site = Site::where('uid', $request->uid)->first();
                $site_id = $site->id;
            }

            // $site = Site::where('uid', $request->uid)->first();
            // $check = Visit::where(['employee_id' => $request->employee_id, 'site_id' => $site->id])->latest()->first();
            // $not_check_out = Visit::where('employee_id', $request->employee_id)->where('site_id', '!=', $site->id)->latest()->first();

            // if (!is_null($not_check_out)) {
            //     if ($not_check_out->status == 0) {
            //         $visit = Visit::create([
            //             'employee_id'   => $not_check_out->employee_id,
            //             'site_id'       => $not_check_out->site_id,
            //             'longitude'     => $not_check_out->longitude,
            //             'latitude'      => $not_check_out->latitude,
            //             'visit_category_id'      => $not_check_out->visit_category_id,
            //             'file'          => $not_check_out->file,
            //             'keterangan'    => $not_check_out->keterangan,
            //             'status'        => 1
            //         ]);
            //     }
            // }

            // if (is_null($check)) {
            //     $status = 0;
            // } else if ($check->status == 0) {
            //     $status = 1;
            // } else if ($check->status == 1) {
            //     $status = 0;
            // }

            $visit = Visit::create([
                'employee_id'           => $request->employee_id,
                'site_id'               => $site_id,
                'longitude'             => $request->longitude,
                'latitude'              => $request->latitude,
                'keterangan'            => $request->keterangan,
                'visit_category_id'     => $request->visit_category_id,
                'file'                  => $request->file,
                'status'                => $request->status
            ]);

            return $this->sendResponse(new VisitResource($visit), 'Visit created successfully');
        } catch (\Exception $th) {
            return $this->sendError('Failed', ['error' => $th->getMessage()]);
        }
    }

    public function employee($id)
    {
        $visits = Visit::orderBy('created_at', 'desc')->where('employee_id', $id)->limit(20)->get();

        // if (is_null($visits)) {
        //     return $this->sendError('Visits not found.');
        // }

        return $this->sendResponse(VisitResource::collection($visits), 'Visits retrieved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
