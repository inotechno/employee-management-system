<?php

namespace App\Http\Controllers\Director;

use App\Models\Submission;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->date;
        return view('_director.submissions.index', compact('date'));
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $submissions = Submission::orderBy('created_at', 'desc')->with('employee', 'employee.user', 'supervisor')->orderBy('created_at', 'DESC');

            if (!empty($request->employee_id)) {
                $submissions = $submissions->where('employee_id', $request->employee_id);
            }

            if (!empty($request->date)) {
                $submissions = $submissions->whereDate('created_at', $request->date);
            }

            $submissions->get();
            // dd($submission);
            return DataTables::of($submissions)
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
                    $button = '';

                    if ($row->validation_director == NULL) {
                        if ($row->user_id != NULL && $row->validation_supervisor == NULL) {
                            $button .= '<span class="badge bg-warning">Waiting Approve Supervisor</span>';
                        } else {
                            $button .= '<a href="' . route('submission.show.director', $row->id) . '" class="btn btn-info btn-sm" data-id="' . $row->id . '">
                                            <i class="bx bx-show bx-xs"></i>
                                        </a>
                                        <button title="Validasi"  class="btn btn-primary btn-sm btn-validation" data-id="' . $row->id . '">
                                            <i class="bx bx-check-shield bx-xs" ></i>
                                        </button>
                                        <button title="Reject"  class="btn btn-danger btn-sm btn-rejection" data-id="' . $row->id . '">
                                            <i class="bx bx-x-circle bx-xs" ></i>
                                        </button>';
                        }
                    }

                    if ($row->validation_director != NULL) {
                        $button .= '<button title="Pending" class="btn btn-warning btn-sm btn-pending" data-id="' . $row->id . '">
                                        <i class="bx bx-undo bx-xs" ></i>
                                    </button>';
                    }

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
        return view('_director.submissions.show', compact('submission'));
    }

    public function validation(Request $request, $id)
    {
        $submission = Submission::find($id);

        try {
            $submission->update([
                'validation_director' => date('Y-m-d H:i:s'),
                'status'        => 1
            ]);

            $input['description'] = $submission->employee->user->name . ' melakukan pengajuan keuangan untuk ' . $submission->title . ' dengan nominal ' . number_format($submission->nominal) . ' mohon untuk melihat dan konfirmasi pengajuan tersebut pada aplikasi <a href="https://ems.tpm-facility.com">https://ems.tpm-facility.com</a><br><br>Terima Kasih';
            $input['subject'] = 'Pengajuan Keuangan ' . $submission->title . ' dari ' . $submission->employee->user->name;

            $input['email'] = 'rekha.kisnawaty@tpm-facility.com';
            $input['name'] = 'Rekha Kisnawaty';
            // $input['email'] = 'ahmad.fatoni@mindotek.com';
            // $input['name'] = 'Ahmad Fatoni';

            Mail::send('email.send_announcement', $input, function ($message) use ($input) {
                $message->to($input['email'], $input['name'])->subject($input['subject']);
            });

            return redirect()->route('submission.director')->with('success', 'Submission validation successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Submission validation failed');
        }
    }

    public function rejection(Request $request, $id)
    {
        // dd($id);
        $submission = Submission::find($id);

        try {
            $submission->update([
                'status'        => 3
            ]);
            // dd($submission);
            return redirect()->route('submission.director')->with('success', 'Submission rejection successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Submission rejection failed');
        }
    }

    public function pending(Request $request, $id)
    {
        // dd($id);
        $submission = Submission::find($id);

        try {
            $submission->update([
                'validation_director' => NULL,
                'validation_finance' => NULL,
                'status'        => 0
            ]);
            // dd($submission);
            return redirect()->route('submission.director')->with('success', 'Submission pending successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', $th->getMessage());
        }
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
