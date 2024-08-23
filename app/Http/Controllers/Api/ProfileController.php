<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends BaseController
{
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'username'              => 'required',
            'name'                  => 'required',
            'tanggal_lahir'         => 'required',
            'tempat_lahir'          => 'required',
            'no_rekening'           => 'required',
            'email'                 => 'email:rfc,dns',
            'foto'                  => 'required|image:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Bad Parameter.', ['error' => $validator->errors()]);
        }

        if ($user->validation_at != null) {
            return $this->sendError('User cannot be updated');
        }

        $data = [];

        if ($request->file('foto')) {
            $foto = $request->file('foto');
            $data['foto'] = $request->username . '.' . $foto->extension();

            $destinationPath = public_path('images/users/');
            $foto->move($destinationPath, $data['foto']);
        }

        $data['name'] = $request->name;
        $data['email'] = $request->email;

        try {

            $user->update($data);

            $empl['position_id']           = $request->position_id;
            $empl['nama_rekening']         = $request->nama_rekening;
            $empl['no_rekening']           = $request->no_rekening;
            $empl['pemilik_rekening']      = $request->pemilik_rekening;
            $empl['tanggal_lahir']         = $request->tanggal_lahir;
            $empl['tempat_lahir']          = $request->tempat_lahir;
            $empl['bpjs_kesehatan']        = $request->bpjs_kesehatan;
            $empl['bpjs_ketenagakerjaan']  = $request->bpjs_ketenagakerjaan;

            $user->employee->update($empl);

            return $this->sendResponse(new ProfileResource($user), 'Employee created successfully');
        } catch (\Exception $th) {
            return $this->sendError('Failed', ['error' => $th->getMessage()]);
        }
    }

    public function update_password(Request $request, $id)
    {
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'confirmed|max:8|different:old_password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Bad Parameter.', ['error' => $validator->errors()]);
        }

        if ($user->validation_at != null) {
            return $this->sendError('User cannot be updated');
        }


        if (Hash::check($request->old_password, $user->password)) {
            $user->fill([
                'password' => Hash::make($request->password)
            ])->save();
        }


        $data['password']         = $request->password;


        try {

            $user->update($data);

            return $this->sendResponse(new ProfileResource($user), 'Password Change successfully');
        } catch (\Exception $th) {
            return $this->sendError('Failed', ['error' => $th->getMessage()]);
        }
    }
}
