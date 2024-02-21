<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Machine;
use App\Models\Employee;
use App\Models\Position;
use Rats\Zkteco\Lib\ZKTeco;
use Illuminate\Http\Request;
use App\Exports\ReportExport;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Imports\ImportEmployeeImport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd($this->zk->connect());

        return view('employees.index');
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

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            // $store = Store::where('user_id', auth()->user()->id)->first();
            $employees = Employee::with('position', 'user')->where('status', 1);
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
                    return '<a class="btn btn-warning btn-sm" href="' . route('employees.edit', $row->id) . '">
                               <i class="bx bx-edit-alt" ></i>
                            </a>
                            <button class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '">
                               <i class="bx bx-trash"></i>
                            </button>';
                })
                ->rawColumns(['action', '_image'])
                ->make(true);
        }
    }

    public function sync()
    {
        $machine = Machine::where('active', 'yes')->first();
        $this->zk = new ZKTeco($machine->ip);

        try {
            $this->zk->connect();
            $get = $this->zk->getUser();
            // dd($get);
            $employee = [];
            // dd($get);
            // DB::table('employees')->truncate();
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

            $this->zk->disconnect();

            return response()->json([
                'success' => true,
                'message' => 'Syncronize Success'
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
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
        return view('employees.edit', compact('employee', 'positions'));
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

            return redirect()->route('employees')->with('success', 'Employee updated successfully');
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
