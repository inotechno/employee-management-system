<?php

namespace App\Http\Controllers\Director;

use App\Models\PaidLeave;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Support\Facades\Mail;

class PaidLeaveController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->date;
        return view('_director.paid_leaves.index', compact('date'));
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $paid_leave = PaidLeave::orderBy('created_at', 'desc')->with('employee', 'employee.user', 'supervisor')->orderBy('created_at', 'DESC');
            // dd($paid_leave);
            if (!empty($request->employee_id)) {
                $paid_leave = $paid_leave->where('employee_id', $request->employee_id);
            }
            if (!empty($request->date)) {
                $paid_leave = $paid_leave->where(function ($builder) use ($request) {
                    $builder
                        ->whereDate('tanggal_mulai', '<=', $request->date)
                        ->whereDate('tanggal_akhir', '>=', $request->date);
                });
            }

            $paid_leave->get();

            return DataTables::of($paid_leave)
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

                    if ($row->validation_hrd != NULL && $row->validation_director == NULL) {
                        $button .= '<a href="' . route('paid_leaves.show.director', $row->id) . '" class="btn btn-info btn-sm" data-id="' . $row->id . '">
                                        <i class="bx bx-show bx-xs"></i>
                                    </a>
                                    <button class="btn btn-primary btn-sm btn-validation" data-id="' . $row->id . '">
                                        <i class="bx bx-check-shield bx-xs" ></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm btn-rejection" data-id="' . $row->id . '">
                                        <i class="bx bx-x-circle bx-xs" ></i>
                                    </button>';
                    } else if ($row->validation_hrd == NULL) {
                        $button .= '<span class="badge bg-warning">Waiting <br>Approve HRD</span>';
                    } else if ($row->user_id != NULL && $row->validation_supervisor == NULL) {
                        $button .= '<span class="badge bg-warning">Waiting <br>Approve Supervisor</span>';
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
        return view('_director.paid_leaves.show', compact('paid_leave'));
    }

    public function validation(Request $request, $id)
    {
        $paid_leave = PaidLeave::find($id);
        $employee = Employee::find($paid_leave->employee_id);

        // dd($jumlah_hari_kerja);
        try {
            $paid_leave->update([
                'validation_director' => date('Y-m-d H:i:s'),
                'status'        => 2
            ]);

            $employee->update([
                'jumlah_cuti' => intval($employee->jumlah_cuti) - intval($paid_leave->total_cuti)
            ]);

            $input['description'] = 'Pengajuan cuti anda sudah di setujui oleh direktur, silahkan lihat selengkapnya di halaman web <a href="https://ems.tpm-facility.com">https://ems.tpm-facility.com</a>';
            $input['subject'] = 'Pengajuan cuti anda telah di setujui oleh direktur';

            $input['email'] = $paid_leave->employee->user->email;
            $input['name'] = $paid_leave->employee->user->name;

            Mail::send('email.send_announcement', $input, function ($message) use ($input) {
                $message->to($input['email'], $input['name'])->subject($input['subject']);
            });

            return redirect()->route('paid_leaves.director')->with('success', 'Paid leave validation successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Paid leave validation failed');
        }
    }

    public function rejection(Request $request, $id)
    {
        // dd($id);
        $paid_leave = PaidLeave::find($id);

        $input['description'] = 'Pengajuan cuti anda sudah ditolak oleh direktur, silahkan lihat selengkapnya di halaman web <a href="https://ems.tpm-facility.com">https://ems.tpm-facility.com</a>';
        $input['subject'] = 'Pengajuan cuti anda telah ditolak oleh direktur';

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
            return redirect()->route('paid_leaves.director')->with('success', 'Paid leave rejection successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Paid leave rejection failed');
        }
    }

    public function destroy($id)
    {
        $paid_leave = PaidLeave::find($id);

        try {
            $paid_leave->delete();
            return redirect()->route('paid_leaves.director')->with('success', 'Paid leave deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Paid leave deleted failed');
        }
    }
}
