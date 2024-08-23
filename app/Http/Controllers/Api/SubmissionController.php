<?php

namespace App\Http\Controllers\Api;

use App\Models\Submission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\SubmissionResource;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SubmissionController extends BaseController
{
    public function index()
    {
        $submissions = Submission::orderBy('created_at', 'desc')->with('employee')->get();
        return $this->sendResponse(SubmissionResource::collection($submissions), 'Submissions retrieved successfully');
    }

    public function employee($id)
    {
        $submissions = Submission::orderBy('created_at', 'desc')->where('employee_id', $id)->get();
        return $this->sendResponse(SubmissionResource::collection($submissions), 'Submissions retrieved successfully');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'nominal'   => 'required|numeric',
            'note'      => 'required|min:10',
            'user_id'   => 'nullable',
            'employee_id'    => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Bad Parameter.', ['error' => $validator->errors()]);
        }

        try {
            $submission = Submission::create([
                'employee_id'       => $request->employee_id,
                'title'             => $request->title,
                'nominal'           => $request->nominal,
                'note'              => $request->note,
            ]);

            $input['description'] = $submission->employee->user->name . ' melakukan pengajuan keuangan untuk ' . $submission->title . ' dengan nominal ' . number_format($submission->nominal) . ' mohon untuk melihat dan konfirmasi pengajuan tersebut pada aplikasi <a href="https://ems.tpm-facility.com">https://ems.tpm-facility.com</a><br><br>Terima Kasih';
            $input['subject'] = 'Pengajuan Keuangan ' . $submission->title . ' dari ' . $submission->employee->user->name;

            $input['email'] = 'prasojo.utomo@tpm-facility.com';
            $input['name'] = 'Prasojo Utomo';
            // $input['email'] = 'ahmad.fatoni@mindotek.com';
            // $input['name'] = 'Ahmad Fatoni';

            $input['cc'] = [];

            if ($request->user_id) {
                $input['cc'][] = User::find($request->user_id)->email;
            }

            Mail::send('email.send_announcement', $input, function ($message) use ($input) {
                $message->to($input['email'], $input['name'])->cc($input['cc'])->subject($input['subject']);
            });

            return $this->sendResponse($submission, 'Submission created successfully');
        } catch (\Exception $th) {
            return $this->sendError('Failed', ['error' => $th->getMessage()]);
        }
    }

    public function show($id)
    {
        $submission = Submission::find($id);

        if (is_null($submission)) {
            return $this->sendError('Submission not found.');
        }

        return $this->sendResponse(new SubmissionResource($submission), 'Submission retrieved successfully');
    }

    public function update(Request $request, $id)
    {
        $submission = Submission::find($id);

        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'nominal'   => 'required|numeric',
            'note'      => 'required|min:10',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Bad Parameter.', ['error' => $validator->errors()]);
        }

        if ($submission->status == 1) {
            return $this->sendError('Submission cannot be updated');
        }

        try {
            $submission->update([
                'title'     => $request->title,
                'nominal'   => $request->nominal,
                'note'      => $request->note,
            ]);

            return $this->sendResponse(new SubmissionResource($submission), 'Submission created successfully');
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
        $submission = Submission::find($id);

        if (is_null($submission)) {
            return $this->sendError('Submission not found.');
        }

        try {
            if ($submission->status == 2) {
                return $this->sendError('Submission cannot be deleted');
            }

            $submission->delete();
            return $this->sendResponse(new SubmissionResource($submission), 'Submission deleted successfully');
        } catch (\Exception $th) {
            return $this->sendError('Failed', ['error' => $th->getMessage()]);
        }
    }

    public function upload_receipt(Request $request, $id)
    {
        // dd($request->all());
        $submission = Submission::find($id);

        $validator = Validator::make($request->all(), [
            'receipt_image'  => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:5048'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Bad Parameter.', ['error' => $validator->errors()]);
        }

        $data = [];
        if ($request->file('receipt_image')) {
            $receipt_image = $request->file('receipt_image');
            $data['receipt_image'] = md5(Str::random(100)) . '.' . $receipt_image->extension();

            $destinationPath = public_path('images/receipts/');
            $receipt_image->move($destinationPath, $data['receipt_image']);
        }

        try {
            $submission->update($data);
            return $this->sendResponse(new SubmissionResource($submission), 'Submission deleted successfully');
        } catch (\Throwable $th) {
            return $this->sendError('Failed', ['error' => $th->getMessage()]);
        }
    }
}
