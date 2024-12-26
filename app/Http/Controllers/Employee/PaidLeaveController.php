<?php

namespace App\Http\Controllers\Employee;

use App\Helpers\SelisihHariCuti;
use App\Models\PaidLeave;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\User;
use DateInterval;
use DatePeriod;
use DateTime;
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
        return view('_employees.paid_leaves.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('_employees.paid_leaves.create');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $paid_leave = PaidLeave::with('supervisor')->where('employee_id', auth()->user()->employee->id)->orderBy('created_at', 'DESC');
            // dd($paid_leave->get()->toArray());
            return DataTables::eloquent($paid_leave)
                ->addIndexColumn()
                // ->filter(function ($instance) use ($request) {
                //     if (!empty($request->get('start_date'))) {
                //         return $instance->collection = $instance
                //             ->whereDate('timestamp', '>=', $request->get('start_date'))
                //             ->whereDate('timestamp', '<=', $request->get('end_date'));
                //         // ->whereBetween('timestamp', array($request->get('start_date'), $request->get('end_date')));
                //     }
                // })
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
                    if ($row->status == 0) {
                        return '<a class="btn btn-warning btn-sm" href="' . route('paid_leaves.edit.employee', $row->id) . '">
                                   <i class="bx bx-edit-alt" ></i>
                                </a>
                                <button class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '">
                                   <i class="bx bx-trash"></i>
                                </button>';
                    }
                })
                ->rawColumns(['_validation_supervisor', '_validation_director', '_validation_hrd', 'action'])
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
            'tanggal_mulai'  => 'required|date|before_or_equal:tanggal_akhir|after_or_equal:' . date('Y-m-d'),
            'tanggal_akhir'  => 'required|date|after_or_equal:tanggal_mulai',
            'user_id'        => 'nullable',
            'description'    => 'required|min:10',
        ]);

        $validator['employee_id'] = auth()->user()->employee->id;

        try {
            $employee = Auth::user()->employee;
            $startDate = strtotime($request->tanggal_mulai);
            $endDate = strtotime($request->tanggal_akhir);
            $jarak = $endDate - $startDate;
            $hari = ($jarak / 60 / 60 / 24) + 1;
            // $array = json_decode(file_get_contents("https://api-harilibur.vercel.app/api"), true);
            $jumlah_hari_kerja = SelisihHariCuti::get($request->tanggal_mulai, $request->tanggal_akhir); // Total jumlah hari kerja
            // dd($jumlah_hari_kerja);
            $validator['total_cuti'] = $jumlah_hari_kerja;
            $validator['sisa_cuti'] = $employee->jumlah_cuti;

            // if ($employee->jumlah_cuti <= 0 || $employee->jumlah_cuti < $jumlah_hari_kerja) {
            //     return redirect()->route('paid_leaves.employee')->with('error', 'Pengajuan cuti gagal, sisa cuti kurang dan jumlah hari.');
            // }

            $paidleave = PaidLeave::create($validator);
            $input['description'] = $paidleave->employee->user->name . ' melakukan pengajuan cuti pada tanggal ' . $paidleave->tanggal_mulai . ' sampai ' . $paidleave->tanggal_akhir . ' dengan keterangan ' . $paidleave->description . ' mohon untuk melihat dan konfirmasi pengajuan tersebut pada aplikasi <a href="https://ems.tpm-facility.com">https://ems.tpm-facility.com</a><br><br>Terima Kasih';
            $input['subject'] = 'Pengajuan Cuti ' . $paidleave->title . ' dari ' . $paidleave->employee->user->name;

            $input['email'] = 'prasojo.utomo@tpm-facility.com';
            $input['name'] = 'Prasojo Utomo';
            // $input['email'] = 'ahmad.fatoni@mindotek.com';
            // $input['name'] = 'Ahmad Fatoni';

            $input['cc'][] = 'endro.setyantono@tpm-facility.com';
            // $input['cc'][] = 'ahmad.fatoni@mindotek.com';

            if ($request->user_id) {
                $input['cc'][] = User::find($request->user_id)->email;
            }

            // dd($input);

            Mail::send('email.send_announcement', $input, function ($message) use ($input) {
                $message->to($input['email'], $input['name'])->cc($input['cc'])->subject($input['subject']);
            });

            return redirect()->route('paid_leaves.employee')->with('success', 'Paid leave added successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', $th->getMessage());
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
        $paid_leave = PaidLeave::find($id);
        return view('_employees.paid_leaves.edit', compact('paid_leave'));
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
        $paid_leave = PaidLeave::find($id);

        $validator = $request->validate([
            'tanggal_mulai'  => 'required|date|before_or_equal:tanggal_akhir|after:' . date('Y-m-d'),
            'tanggal_akhir'  => 'required|date|after_or_equal:tanggal_mulai',
            'description'    => 'required|min:10',
            'user_id'       => 'nullable'
        ]);

        if ($paid_leave->status == 1) {
            return back()->with('error', 'Paid leave cannot be update');
        }

        try {
            $employee = Auth::user()->employee;
            $startDate = strtotime($request->tanggal_mulai);
            $endDate = strtotime($request->tanggal_akhir);
            $jarak = $endDate - $startDate;
            $hari = ($jarak / 60 / 60 / 24) + 1;
            $jumlah_hari_kerja = SelisihHariCuti::get($request->tanggal_mulai, $request->tanggal_akhir); // Total jumlah hari kerja

            $validator['total_cuti'] = $jumlah_hari_kerja;

            // if ($employee->jumlah_cuti <= 0 || $employee->jumlah_cuti < $jumlah_hari_kerja) {
            //     return redirect()->route('paid_leaves.employee')->with('error', 'Pengajuan cuti gagal, sisa cuti kurang dan jumlah hari.');
            // }

            $paid_leave->update($validator);
            return redirect()->route('paid_leaves.employee')->with('success', 'Paid leave updated successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', $th->getMessage());
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
            if ($paid_leave->status == 2) {
                return redirect()->route('paid_leaves.employee')->with('error', 'Paid leave cannot be deleted');
            }

            $paid_leave->delete();
            return redirect()->route('paid_leaves.employee')->with('success', 'Paid leave deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Paid leave deleted failed');
        }
    }



    public function paid_leaves_index()
    {
        return view('_employees.paid_leaves.employee_index');
    }

    public function paid_leaves_show($id)
    {
        $paid_leave = PaidLeave::find($id);
        $paid_leave->update(['seen_at' => date('Y-m-d H:i:s')]);
        return view('_employees.paid_leaves.show', compact('paid_leave'));
    }

    public function paid_leaves_datatable(Request $request)
    {
        if ($request->ajax()) {
            $paid_leave = PaidLeave::where('user_id', Auth::id())->orderBy('created_at', 'desc')->with('employee', 'employee.user', 'supervisor');
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

                    if ($row->validation_supervisor == NULL) {
                        $button .= '<a href="' . route('paid_leaves.show.all', $row->id) . '" class="btn btn-info btn-sm" data-id="' . $row->id . '">
                                        <i class="bx bx-show bx-xs"></i>
                                    </a>
                                    <button class="btn btn-primary btn-sm btn-validation" data-id="' . $row->id . '">
                                        <i class="bx bx-check-shield bx-xs" ></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm btn-rejection" data-id="' . $row->id . '">
                                        <i class="bx bx-x-circle bx-xs" ></i>
                                    </button>';
                    }

                    return $button;
                })
                ->rawColumns(['_validation_supervisor', '_validation_director', '_validation_hrd', 'action'])
                ->make(true);
        }
    }

    public function paid_leaves_validation(Request $request, $id)
    {
        $paid_leave = PaidLeave::find($id);

        try {
            $paid_leave->update([
                'validation_supervisor' => date('Y-m-d H:i:s'),
                'status'        => 1
            ]);

            $input['description'] = 'Pengajuan cuti ' . $paid_leave->employee->user->name . ' sudah di approve oleh supervisor/atasan, silahkan lihat & lakukan approve di halaman web <a href="https://ems.tpm-facility.com">https://ems.tpm-facility.com</a>';
            $input['subject'] = 'Approve Supervisor Pengajuan Cuti ' . $paid_leave->employee->user->name;

            $input['email'] = 'endro.setyantono@tpm-facility.com';
            $input['name'] = 'Endro Setyantono';

            Mail::send('email.send_announcement', $input, function ($message) use ($input) {
                $message->to($input['email'], $input['name'])->subject($input['subject']);
            });

            return redirect()->route('paid_leaves.all')->with('success', 'Paid leave validation successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Paid leave validation failed');
        }
    }

    public function paid_leaves_rejection(Request $request, $id)
    {
        // dd($id);
        $paid_leave = PaidLeave::find($id);

        $input['description'] = 'Pengajuan cuti anda sudah ditolak oleh supervisor/atasan, silahkan lihat selengkapnya di halaman web <a href="https://ems.tpm-facility.com">https://ems.tpm-facility.com</a>';
        $input['subject'] = 'Pengajuan cuti anda telah ditolak oleh supervisor/atasan';

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
            return redirect()->route('paid_leaves.all')->with('success', 'Paid leave rejection successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Paid leave rejection failed');
        }
    }
}
