<?php

namespace App\Http\Controllers\Hrd;

use App\Models\Position;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('_hrd.positions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('_hrd.positions.create');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            // $store = Store::where('user_id', auth()->user()->id)->first();
            $positions = Position::query();
            // dd($order);
            return DataTables::eloquent($positions)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    return '<a class="btn btn-warning btn-sm" href="' . route('positions.edit.hrd', $row->id) . '">
                               <i class="bx bx-edit-alt" ></i>
                            </a>
                            <button class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '">
                               <i class="bx bx-trash"></i>
                            </button>';
                })
                ->rawColumns(['action'])
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
        ]);

        $validator['slug'] = Str::slug($request->name, '-');

        try {
            Position::create($validator);
            return redirect()->route('positions.hrd')->with('success', 'Position added successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Position added failed');
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
        $position = Position::find($id);
        return view('_hrd.positions.edit', compact('position'));
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
        $position = Position::find($id);

        $validator = $request->validate([
            'name'  => 'required',
        ]);

        $validator['slug'] = Str::slug($request->name, '-');

        try {
            $position->update($validator);
            return redirect()->route('positions.hrd')->with('success', 'Position updated successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Position updated failed');
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
        $position = Position::find($id);
        try {
            $position->delete();
            return redirect()->route('positions.hrd')->with('success', 'Position deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Position deleted failed');
        }
    }
}
