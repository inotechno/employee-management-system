<?php

namespace App\Http\Controllers\Employee;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {

        $user = User::find(auth()->user()->id);
        $position = Position::all();
        return view('_employees.profile.index', compact('user', 'position'));
    }


    public function edit($id)
    {
    }


    public function update(Request $request, $id)
    {
        // dd($request->all());
        $user = User::find($id);
        $validator = $request->validate([
            'name'                  => 'required',
            'email'                 => 'email:rfc,dns|unique:users,email,' . $user->id,
            'foto'                  => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);

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

            return redirect()->route('users.employee')->with('success', 'Employee updated successfully');
        } catch (\Throwable $th) {
            return back()->with('error', 'Employee updated failed');
        }
    }

    public function update_password(Request $request, $id)
    {
        $user = User::find($id);
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'confirmed|max:8|different:old_password',
        ]);

        if (Hash::check($request->old_password, $user->password)) {
            $user->fill([
                'password' => Hash::make($request->password)
            ])->save();

            return redirect()->route('users.employee')->with('success', 'Password changed successfully');
        } else {
            return back()->with('error', 'Password changed failed');
        }
    }
}
