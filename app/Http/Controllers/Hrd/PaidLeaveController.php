<?php

namespace App\Http\Controllers\Hrd;

use App\Models\PaidLeave;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PaidLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('_hrd.paid_leaves.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $paid_leave = PaidLeave::orderBy('created_at', 'desc')->with('employee', 'employee.user', 'supervisor');
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
                        return '<span class="badge bg-warning">Waiting <br>Approve</span>';
                    }
                })

                ->addColumn('_validation_director', function ($row) {
                    if ($row->validation_director != NULL) {
                        return '<span class="badge bg-info">' . $row->validation_director . '</span>';
                    } else if ($row->status == 3) {
                        return '<span class="badge bg-danger">Rejected</span>';
                    } else {
                        return '<span class="badge bg-warning">Waiting <br>Approve</span>';
                    }
                })

                ->addColumn('action', function ($row) {
                    $button = '';

                    if ($row->validation_hrd == NULL) {
                        if ($row->user_id != NULL && $row->validation_supervisor == NULL) {
                            $button .= '<span class="badge bg-warning">Waiting <br>Approve Supervisor</span>';
                        } else {
                            $button .= '<a href="' . route('paid_leaves.show.hrd', $row->id) . '" class="btn btn-info btn-sm" data-id="' . $row->id . '">
                                            <i class="bx bx-show bx-xs"></i>
                                        </a>
                                        <button class="btn btn-primary btn-sm btn-validation" data-id="' . $row->id . '">
                                            <i class="bx bx-check-shield bx-xs" ></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm btn-rejection" data-id="' . $row->id . '">
                                            <i class="bx bx-x-circle bx-xs" ></i>
                                        </button>';
                        }
                    }

                    return $button;
                })
                ->rawColumns(['_validation_supervisor', '_validation_director', '_validation_hrd', 'action'])
                ->make(true);
        }
    }

    public function show($id)
    {
        $paid_leave = PaidLeave::find($id);
        $paid_leave->update(['seen_at' => date('Y-m-d H:i:s')]);
        return view('_hrd.paid_leaves.show', compact('paid_leave'));
    }

    public function validation(Request $request, $id)
    {
        $paid_leave = PaidLeave::find($id);

        try {
            $paid_leave->update([
                'validation_hrd' => date('Y-m-d H:i:s'),
                'status'        => 1
            ]);

            $input['description'] = 'Pengajuan cuti ' . $paid_leave->employee->user->name . ' sudah di approve oleh hrd, silahkan lihat & lakukan approve di halaman web <a href="https://ems.tpm-facility.com">https://ems.tpm-facility.com</a>';
            $input['subject'] = 'Approve HRD Pengajuan Cuti ' . $paid_leave->employee->user->name;

            $input['email'] = 'prasojo.utomo@tpm-facility.com';
            $input['name'] = 'Prasojo Utomo';

            Mail::send('email.send_announcement', $input, function ($message) use ($input) {
                $message->to($input['email'], $input['name'])->subject($input['subject']);
            });

            return redirect()->route('paid_leaves.hrd')->with('success', 'Paid leave validation successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Paid leave validation failed');
        }
    }

    public function rejection(Request $request, $id)
    {
        // dd($id);
        $paid_leave = PaidLeave::find($id);

        $input['description'] = 'Pengajuan cuti anda sudah ditolak oleh hrd, silahkan lihat selengkapnya di halaman web <a href="https://ems.tpm-facility.com">https://ems.tpm-facility.com</a>';
        $input['subject'] = 'Pengajuan cuti anda telah ditolak oleh hrd';

        $input['email'] = $paid_leave->employee->user->email;
        $input['name'] = $paid_leave->employee->user->name;

        Mail::send('email.send_announcement', $input, function ($message) use ($input) {
            $message->to($input['email'], $input['name'])->subject($input['subject']);
        });

        try {
            $paid_leave->update([
                'status'        => 3
            ]);
            // dd($paid_leave);
            return redirect()->route('paid_leaves.hrd')->with('success', 'Paid leave rejection successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Paid leave rejection failed');
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
        $paid_leave = PaidLeave::find($id);

        try {
            $paid_leave->delete();
            return redirect()->route('paid_leaves.hrd')->with('success', 'Paid leave deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Paid leave deleted failed');
        }
    }
}
