<?php

namespace App\Http\Controllers\Admin;

use App\Models\PaidLeave;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PaidLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('paid_leaves.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('paid_leaves.create');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $paid_leave = PaidLeave::orderBy('created_at', 'desc')->with('employee', 'employee.user', 'supervisor')->orderBy('created_at', 'DESC');
            // dd($paid_leave);
            return DataTables::eloquent($paid_leave)
                ->addIndexColumn()
                ->addColumn('supervisor', function ($row) {
                    if ($row->user_id != NULL) {
                        return $row->supervisor->name;
                    }

                    return '-';
                })
                ->addColumn('_validation_supervisor', function ($row) {
                    if ($row->validation_supervisor != NULL) {
                        return '<span class="badge bg-info">' . $row->validation_supervisor . '</span>';
                    } else if ($row->status == 3) {
                        return '<span class="badge bg-danger">Rejected</span>';
                    } else if ($row->user_id == NULL) {
                        return '<span class="badge bg-secondary">Not Found <br>Supervisor</span>';
                    } else {
                        return '<span class="badge bg-warning">Waiting <br>Approve</span>';
                    }
                })

                ->addColumn('_validation_hrd', function ($row) {
                    if ($row->validation_hrd != NULL) {
                        return '<span class="badge bg-info">' . $row->validation_hrd . '</span>';
                    } else if ($row->status == 3) {
                        return '<span class="badge bg-danger">Rejected</span>';
                    } else {
                        return '<span class="badge bg-warning">Waiting Approve</span>';
                    }
                })

                ->addColumn('_validation_director', function ($row) {
                    if ($row->validation_director != NULL) {
                        return '<span class="badge bg-info">' . $row->validation_director . '</span>';
                    } else if ($row->status == 3) {
                        return '<span class="badge bg-danger">Rejected</span>';
                    } else {
                        return '<span class="badge bg-warning">Waiting Approve</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('paid_leaves.show', $row->id) . '" class="btn btn-info btn-sm" data-id="' . $row->id . '">
                                <i class="bx bx-show bx-xs"></i>
                            </a>
                            <button class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '">
                                <i class="bx bx-trash-alt bx-xs" ></i>
                            </button>';
                })
                ->rawColumns(['_validation_supervisor', '_validation_director', '_validation_hrd', 'action'])
                ->make(true);
        }
    }

    public function show($id)
    {
        $paid_leave = PaidLeave::find($id);
        $paid_leave->update(['seen_at' => date('Y-m-d H:i:s')]);
        return view('paid_leaves.show', compact('paid_leave'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paid_leave = PaidLeave::find($id);

        try {
            $paid_leave->delete();
            return redirect()->route('paid_leaves')->with('success', 'Paid leave deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Paid leave deleted failed');
        }
    }
}
