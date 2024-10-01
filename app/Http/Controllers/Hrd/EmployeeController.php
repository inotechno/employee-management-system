<?php

namespace App\Http\Controllers\Hrd;

use App\Models\User;
use App\Models\Machine;
use App\Models\Employee;
use App\Models\Position;
use Rats\Zkteco\Lib\ZKTeco;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    function __construct()
    {
        // $machine = Machine::where('active', 'yes')->first();
        // $this->zk = new ZKTeco($machine->ip);
        // $this->zk->connect();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd($this->zk->connect());

        return view('_hrd.employees.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('_hrd.employees.create');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            // $store = Store::where('user_id', auth()->user()->id)->first();
            $employees = Employee::with('position', 'user');
            // dd($order);
            return DataTables::eloquent($employees)
                ->addIndexColumn()
                ->addColumn('_image', function ($row) {
                    if ($row->user->foto != NULL) {
                        return '<img src="https://ems.tpm-facility.com/images/users/' . $row->user->foto . '" alt="" class="avatar-xs h-auto rounded">';
                    }

                    return '<img src="' . asset('images/users/default.jpg') . '" alt="" class="avatar-xs h-auto rounded">';
                })
                ->addColumn('action', function ($row) {
                    return '<a class="btn btn-warning btn-sm" href="' . route('employees.edit.hrd', $row->id) . '">
                               <i class="bx bx-edit-alt" ></i>
                            </a>';
                })
                ->rawColumns(['action', '_image'])
                ->make(true);
        }
    }

    public function sync()
    {
        // $get = $this->zk->getUser();
        // dd($get);
        $employee = [];
        // dd($get);
        DB::table('employees')->truncate();
        foreach ($get as $user => $val) {

            $user = User::updateOrCreate([
                'username' => $val['userid']
            ], [
                'name'      => $val['name'],
                'password'  => bcrypt($val['userid'])
            ]);

            $user->assignRole('employee');

            $employee = Employee::updateOrCreate([
                'id' => $val['userid']
            ], [
                'user_id' => $user->id,
                'card_number' => $val['cardno'],
            ]);
        }

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $positions = Position::all();
        $employee = Employee::with('user')->find($id);
        return view('_hrd.employees.edit', compact('employee', 'positions'));
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
        $employee = Employee::with('user')->find($id);
        $validator = $request->validate([
            'name'              => 'required',
            'email'             => 'email:rfc,dns',
        ]);

        $empl['position_id']           = $request->position_id;
        $empl['card_number']           = $request->card_number;
        $empl['tanggal_lahir']         = $request->tanggal_lahir;
        $empl['tempat_lahir']          = $request->tempat_lahir;
        $empl['bpjs_kesehatan']        = $request->bpjs_kesehatan;
        $empl['bpjs_ketenagakerjaan']  = $request->bpjs_ketenagakerjaan;
        $empl['status']                = $request->status;
        $empl['nama_rekening']         = $request->nama_rekening;
        $empl['no_rekening']           = $request->no_rekening;
        $empl['pemilik_rekening']      = $request->pemilik_rekening;
        $empl['jumlah_cuti']           = $request->jumlah_cuti;

        try {
            $employee->update($empl);
            $employee->user()->update($validator);

            return redirect()->route('employees.hrd')->with('success', 'Employee updated successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Employee updated failed');
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
        //
    }
}
