<?php

namespace App\Http\Controllers\Admin;

use App\Models\Submission;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class SubmissionController extends Controller
{
    public function index()
    {
        return view('submissions.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $submissions = Submission::orderBy('created_at', 'desc')->with('employee', 'employee.user', 'supervisor')->orderBy('created_at', 'DESC');
            // dd($submission);
            return DataTables::eloquent($submissions)
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
                ->addColumn('_validation_director', function ($row) {
                    if ($row->validation_director != NULL) {
                        return '<span class="badge bg-info">' . $row->validation_director . '</span>';
                    } else if ($row->status == 3) {
                        return '<span class="badge bg-danger">Rejected</span>';
                    } else {
                        return '<span class="badge bg-warning">Waiting Approve</span>';
                    }
                })

                ->addColumn('_validation_finance', function ($row) {
                    if ($row->validation_finance != NULL) {
                        return '<span class="badge bg-info">' . $row->validation_finance . '</span>';
                    } else if ($row->status == 3) {
                        return '<span class="badge bg-danger">Rejected</span>';
                    } else {
                        return '<span class="badge bg-warning">Waiting Approve</span>';
                    }
                })
                ->addColumn('_note', function ($row) {
                    return substr($row->note, 0, 200);
                })
                ->addColumn('action', function ($row) {
                    $button = '<a href="' . route('submission.show', $row->id) . '" class="btn btn-info btn-sm" data-id="' . $row->id . '">
                                    <i class="bx bx-show bx-xs"></i>
                                </a>
                                <button class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '">
                                    <i class="bx bx-trash-alt bx-xs" ></i>
                                </button>';

                    if ($row->receipt_image != NULL) {
                        $button .= '<a title="Bukti" target="_blank" href="' . asset('images/receipts/' . $row->receipt_image) . '" class="btn btn-warning btn-sm btn-receipt" data-id="' . $row->id . '">
                                        <i class="bx bx-receipt bx-xs"></i>
                                    </a>';
                    }

                    return $button;
                })
                ->rawColumns(['_validation_supervisor', '_validation_director', '_validation_finance', '_note', 'action'])
                ->make(true);
        }
    }

    public function show($id)
    {
        $submission = Submission::find($id);
        $submission->update(['seen_at' => date('Y-m-d H:i:s')]);
        return view('submissions.show', compact('submission'));
    }

    public function destroy($id)
    {
        $submission = Submission::find($id);

        try {
            $submission->delete();
            return redirect()->route('submission.director')->with('success', 'Submission deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Submission deleted failed');
        }
    }
}
