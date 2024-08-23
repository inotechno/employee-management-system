<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserSettingController extends Controller
{
    public function index()
    {

        return view('role_permission.index');
    }

    public function datatable(Request $request)
    {
        // dd($request);
        if ($request->ajax()) {
            $users = User::with('roles')->whereHas('roles', function ($query) {
                return $query->where('name', '!=', 'employee');
            });
            // dd($attendances);
            // die($users);
            return DataTables::eloquent($users)
                ->addIndexColumn()

                ->addColumn('role_name', function ($row) {
                    return $row->roles->first()->name;
                })

                ->addColumn('action', function ($row) {
                    return '<a class="btn btn-warning btn-sm" href="' . route('pegawai.edit', $row->id) . '">
                               <i class="bx bx-edit-alt" ></i>
                            </a>
                            <button class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '">
                               <i class="bx bx-trash"></i>
                            </button>';
                })
                ->rawColumns(['action', 'role_name'])
                ->make(true);
        }
    }

    public function create()
    {
        $roles = Role::where('name', '!=', 'employee')->get();
        return view('role_permission.create', compact('roles'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'string', 'min:8'],
            'username'  => ['required'],
        ]);


        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);


            $user->assignRole($request->role);

            return redirect()->route('pegawai')->with('success', 'User added successfully');
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('error', 'User added failed');
        }
    }


    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::where('name', '!=', 'employee')->get();
        return view('role_permission.edit', compact('roles', 'user'));
    }


    public function update(Request $request, $id)
    {
        $user = User::find($id);

        // if ($request->password == null) {
        //     $password = $user->password;
        // } else {
        //     $password = bcrypt($request->password);
        // }

        $validator = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            // 'password'  => ['required', 'string', 'min:8'],
            'username'  => ['required'],
        ]);


        try {
            $data['name']          = $request->name;
            $data['email']         = $request->email;
            $data['username']      = $request->username;

            $user->update($data);
            $user->assignRole($request->role);

            return redirect()->route('pegawai')->with('success', 'User edit successfully');
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('error', 'User edit failed');
        }
    }

    public function destroy($id)
    {

        $user = User::find($id);
        try {
            $user->delete();
            return redirect()->route('pegawai')->with('success', 'User deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'User deleted failed');
        }
    }
}
