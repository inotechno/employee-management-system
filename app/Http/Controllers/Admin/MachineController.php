<?php

namespace App\Http\Controllers\Admin;

use App\Models\Machine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Rats\Zkteco\Lib\ZKTeco;
use KwikKoders\Zkteco\Http\Library\ZktecoLib;

class MachineController extends Controller
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
        // $machine = Machine::where('active', 'yes')->first();
        // $this->zk = new ZktecoLib('192.168.20.221', 4370);
        // $this->zk = new ZKTeco('192.168.20.221', 4370);
        // $this->zk->connect();
        // dd($this->zk->getUser());
        // $this->zk->disconnect();
        return view('machines.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('machines.create');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            // $store = Store::where('user_id', auth()->user()->id)->first();
            $machine = Machine::orderBy('active');
            // dd($order);
            return DataTables::eloquent($machine)
                ->addIndexColumn()
                ->addColumn('active_switch', function ($row) {
                    if ($row->active == 'no') {
                        return '<div class="form-check form-switch form-switch-lg mb-3" dir="ltr">
                                    <input class="form-check-input btn-update-active" data-id="' . $row->id . '" type="checkbox">
                                    <label class="form-check-label">Not Active</label>
                                </div>';
                    }

                    return '<div class="form-check form-switch form-switch-lg mb-3" dir="ltr">
                                    <input class="form-check-input btn-update-active" data-id="' . $row->id . '" type="checkbox" checked="">
                                    <label class="form-check-label">Active</label>
                                </div>';
                })
                ->addColumn('action', function ($row) {
                    return '<a class="btn btn-warning btn-sm" href="' . route('machines.edit', $row->id) . '">
                               <i class="bx bx-edit-alt" ></i>
                            </a>
                            <button class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '">
                               <i class="bx bx-trash"></i>
                            </button>';
                })
                ->addColumn('name_connect', function ($row) {
                    $badge = '';
                    // if ($this->zk->connect()) {
                    //     $badge = '<span class="badge bg-success">Connected</span>';
                    // }

                    return $row->name . $badge;
                })
                ->rawColumns(['action', 'active_switch', 'name_connect'])
                ->make(true);
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
        // dd($request);
        $validator = $request->validate([
            'name'  => 'required',
            'ip'    => 'ip|required',
            'port'  => 'required|numeric',
        ]);

        $validator['comkey'] = $request->comkey;

        try {
            Machine::create($validator);
            return redirect()->route('machines')->with('success', 'Machine added successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Machine added failed');
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $machine = Machine::find($id);
        return view('machines.edit', compact('machine'));
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
        $machine = Machine::find($id);

        $validator = $request->validate([
            'name'  => 'required',
            'ip'    => 'ip|required',
            'port'  => 'required|numeric',
        ]);

        $validator['comkey'] = $request->comkey;

        try {
            $machine->update($validator);
            return redirect()->route('machines')->with('success', 'Machine updated successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Machine updated failed');
        }
    }

    public function active(Request $request, $id)
    {
        $machine = Machine::find($id);
        $data['active'] = 'yes';

        try {
            $machine->update($data);
            $not_machine = Machine::where("id", '!=', $id)->update(['active' => 'no']);
            // dd($not_machine);

            return redirect()->route('machines')->with('success', 'Machine updated successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Machine updated failed');
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
        $machine = Machine::find($id);
        try {
            $machine->delete();
            return redirect()->route('machines')->with('success', 'Machine deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Machine deleted failed');
        }
    }
}
