<?php

namespace App\Http\Controllers\Api;

use App\Models\PaidLeave;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaidLeaveResource;
use App\Models\User;
use App\Helpers\SelisihHariCuti;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PaidLeaveController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paidleaves = PaidLeave::orderBy('created_at', 'desc')->get();
        return $this->sendResponse(PaidLeaveResource::collection($paidleaves), 'Paid leave retrieved successfully');
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
        $paid_leaves = PaidLeave::orderBy('created_at', 'desc')->where('employee_id', $id)->get();
        return $this->sendResponse(PaidLeaveResource::collection($paid_leaves), 'Paid leave retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $input['cc'] = [];
        $validator = Validator::make($request->all(), [
            'tanggal_mulai'  => 'required|date|before_or_equal:tanggal_akhir|after:' . date('Y-m-d'),
            'tanggal_akhir'  => 'required|date|after_or_equal:tanggal_mulai',
            'description'    => 'required|min:10',
            'user_id'        => 'nullable',
            'employee_id'    => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Bad Parameter.', ['error' => $validator->errors()]);
        }

        try {
            $data = $request->all();
            $employee = auth()->user()->employee;
            $startDate = strtotime($request->tanggal_mulai);
            $endDate = strtotime($request->tanggal_akhir);
            $jarak = $endDate - $startDate;
            $hari = ($jarak / 60 / 60 / 24) + 1;
            $jumlah_hari_kerja = SelisihHariCuti::get($request->tanggal_mulai, $request->tanggal_akhir); // Total jumlah hari kerja

            $data['total_cuti'] = $jumlah_hari_kerja;

            // if ($employee->jumlah_cuti <= 0 || $employee->jumlah_cuti < $jumlah_hari_kerja) {
            //     return $this->sendError('Pengajuan cuti gagal, sisa cuti kurang dan jumlah hari.');
            // }

            $paidleave = PaidLeave::create($data);
            $input['description'] = $paidleave->employee->user->name . ' melakukan pengajuan cuti pada tanggal ' . $paidleave->tanggal_mulai . ' sampai ' . $paidleave->tanggal_akhir . ' dengan keterangan ' . $paidleave->description . ' mohon untuk melihat dan konfirmasi pengajuan tersebut pada aplikasi <a href="https://ems.tpm-facility.com">https://ems.tpm-facility.com</a><br><br>Terima Kasih';
            $input['subject'] = 'Pengajuan Cuti ' . $paidleave->title . ' dari ' . $paidleave->employee->user->name;

            $input['email'] = 'prasojo.utomo@tpm-facility.com';
            $input['name'] = 'Prasojo Utomo';
            // $input['email'] = 'ahmad.fatoni@mindotek.com';
            // $input['name'] = 'Ahmad Fatoni';

            $input['cc'][] = 'endro.setyantono@tpm-facility.com';
            // $input['cc'][] = 'ahmad.fatoni@mindotek.com';

            if ($request->user_id) {
                $input['cc'][] = User::find($request->user_id)->email;
            }

            // dd($input);

            Mail::send('email.send_announcement', $input, function ($message) use ($input) {
                $message->to($input['email'], $input['name'])->cc($input['cc'])->subject($input['subject']);
            });

            return $this->sendResponse($paidleave, 'Paid leave created successfully');
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
        $paidleave = PaidLeave::find($id);

        if (is_null($paidleave)) {
            return $this->sendError('Paid leave not found.');
        }

        return $this->sendResponse(new PaidLeaveResource($paidleave), 'Paid leave retrieved successfully');
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
        $paidleave = PaidLeave::find($id);

        $validator = Validator::make($request->all(), [
            'tanggal_mulai'  => 'required|date|before_or_equal:tanggal_akhir|after:' . date('Y-m-d'),
            'tanggal_akhir'  => 'required|date|after_or_equal:tanggal_mulai',
            'description'    => 'required|min:10',
            'employee_id'    => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Bad Parameter.', ['error' => $validator->errors()]);
        }

        if ($paidleave->status == 1) {
            return $this->sendError('Paid leave cannot be updated');
        }

        try {
            $employee = auth()->user()->employee;
            $startDate = strtotime($request->tanggal_mulai);
            $endDate = strtotime($request->tanggal_akhir);
            $jarak = $endDate - $startDate;
            $hari = ($jarak / 60 / 60 / 24) + 1;
            $jumlah_hari_kerja = SelisihHariCuti::get($request->tanggal_mulai, $request->tanggal_akhir); // Total jumlah hari kerja

            $total_cuti = $jumlah_hari_kerja;

            if ($employee->jumlah_cuti <= 0 || $employee->jumlah_cuti < $jumlah_hari_kerja) {
                return $this->sendError('Pengajuan cuti gagal, sisa cuti kurang dan jumlah hari.');
            }

            $paidleave->update([
                'employee_id'   => $request->employee_id,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_akhir' => $request->tanggal_akhir,
                'description'   => $request->description,
                'total_cuti'    => $total_cuti
            ]);

            return $this->sendResponse(new PaidLeaveResource($paidleave), 'Paid leave created successfully');
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
        $paid_leave = PaidLeave::find($id);

        if (is_null($paid_leave)) {
            return $this->sendError('Paid leave not found.');
        }

        try {
            if ($paid_leave->status == 2) {
                return $this->sendError('Paid leave cannot be deleted');
            }

            $paid_leave->delete();
            return $this->sendResponse(new PaidLeaveResource($paid_leave), 'Paid leave deleted successfully');
        } catch (\Exception $th) {
            return $this->sendError('Failed', ['error' => $th->getMessage()]);
        }
    }
}
