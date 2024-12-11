<?php

namespace App\Http\Controllers\Employee;

use App\Models\Absent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AbsentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('_employees.absents.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('_employees.absents.create');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $absent = Absent::with('validation_user')->where('employee_id', auth()->user()->employee->id);
            // dd($absent->get());
            return DataTables::eloquent($absent)
                ->addIndexColumn()
                // ->filter(function ($instance) use ($request) {
                //     if (!empty($request->get('start_date'))) {
                //         return $instance->collection = $instance
                //             ->whereDate('timestamp', '>=', $request->get('start_date'))
                //             ->whereDate('timestamp', '<=', $request->get('end_date'));
                //         // ->whereBetween('timestamp', array($request->get('start_date'), $request->get('end_date')));
                //     }
                // })
                ->addColumn('_validation_at', function ($row) {
                    if ($row->validation_at != NULL) {
                        return  $row->validation_at;
                    }
                })

                ->addColumn('_validation_by', function ($row) {
                    if ($row->validation_by != NULL) {
                        return  $row->validation_user->name;
                    }

                    return '<span class="badge bg-warning">Belum di validasi</span>';
                })

                ->addColumn('_status', function ($row) {
                    if ($row->validation_by != NULL) {
                        return '<span class="badge bg-info">Validated</span>';
                    } else if ($row->status == 2) {
                        return '<span class="badge bg-danger">Rejected</span>';
                    } else {
                        return '<span class="badge bg-warning">Waiting Approve</span>';
                    }
                })

                ->addColumn('action', function ($row) {
                    $button = "";
                    if ($row->status == 0) {
                        $button .= '<a class="btn btn-warning btn-sm" href="' . route('absents.edit.employee', $row->id) . '">
                                   <i class="bx bx-edit-alt" ></i>
                                </a>
                                <button class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '">
                                   <i class="bx bx-trash"></i>
                                </button>';
                    }

                    if ($row->file != NULL) {
                        $button .= '<button class="btn btn-primary ms-1 btn-sm btn-view-file" data-file="' .$row->file . '" data-id="' . $row->id . '" title="View File">
                                            <i class="bx bx-file-find bx-xs"></i>
                                        </button>';
                    } else {
                        $button .= '<button class="btn btn-info btn-sm btn-upload" data-id="' . $row->id . '" title="Upload File">
                                        <i class="bx bxs-file-plus bx-xs"></i>
                                    </button>';
                    }

                    return $button;
                })
                ->rawColumns(['_validation_at', '_validation_by', '_status', 'action'])
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
            'date'  => 'required|date|after_or_equal:' . date('Y-m-d'),
            'description'    => 'required|min:10',
        ]);

        $validator['employee_id'] = auth()->user()->employee->id;

        try {
            // if (auth()->user()->employee->jumlah_cuti == 0) {
            //     return redirect()->route('absents.employee')->with('error', 'Pengajuan cuti gagal, tidak ada sisa cuti.');
            // }

            Absent::create($validator);
            return redirect()->route('absents.employee')->with('success', 'Absent added successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Absent added failed');
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
        $absent = Absent::find($id);
        return view('_employees.absents.edit', compact('absent'));
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
        $absent = Absent::find($id);

        $validator = $request->validate([
            'date'          => 'required|date|after:' . date('Y-m-d'),
            'description'   => 'required|min:10',
        ]);

        if ($absent->status == 1) {
            return back()->with('error', 'Absent cannot be update');
        }

        try {
            $absent->update($validator);
            return redirect()->route('absents.employee')->with('success', 'Absent updated successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Absent updated failed');
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
        $absent = Absent::find($id);

        try {
            if ($absent->status == 2) {
                return redirect()->route('absents.employee')->with('error', 'Absent cannot be deleted');
            }

            $absent->delete();
            return redirect()->route('absents.employee')->with('success', 'Absent deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Absent deleted failed');
        }
    }

    public function upload(Request $request)
    {
        $validate = $request->validate([
            'file' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:3072'
        ]);

        try {
            $absent = Absent::find($request->id);

            if ($request->file('file')) {
                $file = $request->file('file');
                $path = $file->store('images/absents', 'gcs');

                $data['file'] = Storage::disk('gcs')->url($path);
            }

            $absent->update($data);
            return redirect()->route('absents.employee')->with('success', 'Upload file successfully');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
