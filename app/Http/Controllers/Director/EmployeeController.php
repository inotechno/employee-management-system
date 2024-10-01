<?php

namespace App\Http\Controllers\Director;

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
    // function __construct()
    // {
    //     $machine = Machine::where('active', 'yes')->first();
    //     $this->zk = new ZKTeco($machine->ip);
    //     $this->zk->connect();
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd($this->zk->connect());

        return view('_director.employees.index');
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
                ->rawColumns(['_image'])
                ->make(true);
        }
    }

    public function sync()
    {
        $get = $this->zk->getUser();
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
}
