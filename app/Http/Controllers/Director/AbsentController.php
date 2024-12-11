<?php

namespace App\Http\Controllers\Director;

use App\Models\Absent;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AbsentController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->date;
        return view('_director.absents.index', compact('date'));
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $absent = Absent::orderBy('created_at', 'desc')->with('employee', 'employee.user', 'validation_user')->orderBy('created_at', 'DESC');
            if (!empty($request->employee_id)) {
                $absent = $absent->where('employee_id', $request->employee_id);
            }
            if (!empty($request->date)) {
                $absent = $absent->whereDate('date', $request->date);
            }

            $absent->get();
            // dd($absent->get());
            return DataTables::of($absent)
                ->addIndexColumn()
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
                    $button = '';

                    if ($row->status == 0) {
                        $button .= '<button class="btn btn-primary btn-sm btn-validation" data-id="' . $row->id . '">
                                        <i class="bx bx-check-shield bx-xs" ></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm btn-rejection" data-id="' . $row->id . '">
                                        <i class="bx bx-x-circle bx-xs" ></i>
                                    </button>';
                    }

                    if ($row->file != NULL) {
                        $button .= '<button class="btn btn-primary ms-1 btn-sm btn-view-file" data-file="' . $row->file . '" data-id="' . $row->id . '" title="View File">
                                        <i class="bx bx-file-find bx-xs"></i>
                                    </button>';
                    }

                    return $button;
                })

                ->rawColumns(['_validation_at', '_validation_by', '_status', 'action'])
                ->make(true);
        }
    }

    public function validation(Request $request, $id)
    {
        $absent = Absent::find($id);

        try {
            $absent->update([
                'validation_by' => Auth::user()->id,
                'validation_at' => date('Y-m-d H:i:s'),
                'status'        => 1
            ]);
            return redirect()->route('absents.director')->with('success', 'Absent validation successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Absent validation failed');
        }
    }

    public function rejection(Request $request, $id)
    {
        // dd($id);
        $absent = Absent::find($id);

        try {
            $absent->update([
                'status'        => 2
            ]);
            // dd($absent);
            return redirect()->route('absents.director')->with('success', 'Absent rejection successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Absent rejection failed');
        }
    }

    public function destroy($id)
    {
        $absent = Absent::find($id);

        try {
            $absent->delete();
            return redirect()->route('absents.director')->with('success', 'Absent deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Absent deleted failed');
        }
    }
}
