<?php

namespace App\Http\Controllers\Employee;

use App\Models\Submission;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('_employees.submissions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('_employees.submissions.create');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $submission = Submission::with('supervisor')->where('employee_id', auth()->user()->employee->id)->orderBy('created_at', 'DESC');
            // dd($submission->get());
            return DataTables::eloquent($submission)
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
                ->addColumn('action', function ($row) {
                    if ($row->status == 0) {
                        return '<a class="btn btn-warning btn-sm" href="' . route('submission.edit.employee', $row->id) . '">
                                   <i class="bx bx-edit-alt" ></i>
                                </a>
                                <button class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '">
                                   <i class="bx bx-trash"></i>
                                </button>';
                    }

                    if ($row->receipt_image == NULL) {
                        return '<button title="Upload Bukti" class="btn btn-secondary btn-sm btn-receipt" data-id="' . $row->id . '">
                                    <i class="bx bx-receipt bx-xs"></i>
                                </button>';
                    } else {
                        return '<a title="Bukti" target="_blank" href="' . $row->receipt_image . '" class="btn btn-warning btn-sm" data-id="' . $row->id . '">
                                    <i class="bx bx-receipt bx-xs"></i>
                                </a>';
                    }
                })

                ->addColumn('_note', function ($row) {
                    return substr($row->note, 0, 200);
                })

                ->rawColumns(['_validation_supervisor', '_validation_director', '_validation_finance', '_note', 'action'])
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
            'title'     => 'required',
            'nominal'       => 'required|numeric',
            'note'      => 'required|min:10',
            'user_id'   => 'nullable'
        ]);

        $validator['employee_id'] = auth()->user()->employee->id;


        try {
            // $content = $request->note;
            // $dom = new \DomDocument();
            // $dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            // $imageFile = $dom->getElementsByTagName('img');

            // foreach ($imageFile as $item => $image) {
            //     $data = $image->getAttribute('src');
            //     list($type, $data) = explode(';', $data);
            //     list(, $data)      = explode(',', $data);
            //     $imgeData = base64_decode($data);
            //     $image_name = "/images/uploads/" . time() . $item . '.png';
            //     $path = public_path() . $image_name;
            //     file_put_contents($path, $imgeData);
            //     $image->removeAttribute('src');
            //     $image->setAttribute('src', $image_name);
            // }

            // $content = $dom->saveHTML();

            // $validator['note'] = $content;

            $submission = Submission::create($validator);

            $input['description'] = $submission->employee->user->name . ' melakukan pengajuan keuangan untuk ' . $submission->title . ' dengan nominal ' . number_format($submission->nominal) . ' mohon untuk melihat dan konfirmasi pengajuan tersebut pada aplikasi <a href="https://ems.tpm-facility.com">https://ems.tpm-facility.com</a><br><br>Terima Kasih';
            $input['subject'] = 'Pengajuan Keuangan ' . $submission->title . ' dari ' . $submission->employee->user->name;

            $input['email'] = 'prasojo.utomo@tpm-facility.com';
            $input['name'] = 'Prasojo Utomo';
            // $input['email'] = 'ahmad.fatoni@mindotek.com';
            // $input['name'] = 'Ahmad Fatoni';

            $input['cc'] = [];

            if ($request->user_id) {
                $input['cc'][] = User::find($request->user_id)->email;
            }

            Mail::send('email.send_announcement', $input, function ($message) use ($input) {
                $message->to($input['email'], $input['name'])->cc($input['cc'])->subject($input['subject']);
            });

            return redirect()->route('submission.employee')->with('success', 'Submission added successfully');
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
        $submission = Submission::find($id);
        return view('_employees.submissions.edit', compact('submission'));
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
        $submission = Submission::find($id);

        $validator = $request->validate([
            'title'     => 'required',
            'nominal'       => 'required|numeric',
            'note'      => 'required|min:10',
        ]);

        if ($submission->status == 1) {
            return redirect()->route('submission.employee')->with('error', 'Submission cannot be deleted');
        }

        try {
            $submission->update($validator);
            return redirect()->route('submission.employee')->with('success', 'Submission updated successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Submission updated failed');
        }
    }

    public function email_submission($id)
    {
        $submission = Submission::find($id);
        return view('_employees.submissions.send_email_submission', compact('submission'));
    }

    function send_submission_email(Request $request, $id)
    {
        $validator = $request->validate([
            'email'          => 'required|email:rfc,dns',
            'cc'          => 'required',
        ]);

        $submission = Submission::find($id);

        $detail['title'] = $submission->title;
        $detail['nominal'] = $submission->nominal;
        $detail['note'] = $submission->note;

        $request['from'] = auth()->user()->email;
        $request['name'] = auth()->user()->name;

        try {
            if (empty($request->cc)) {
                Mail::send('email.send_submission', $detail, function ($message) use ($request, $submission) {
                    $message->to($request->email)->from('info@rumahaplikasi.co.id', $submission->employee->user->name . ' ' . $submission->employee->user->email)->subject('Pengajuan Keuangan');
                });
            } else {
                Mail::send('email.send_submission', $detail, function ($message) use ($request, $submission) {
                    $message->to($request->email)->from('info@rumahaplikasi.co.id', $submission->employee->user->name . ' ' . $submission->employee->user->email)->cc($request->cc)->subject('Pengajuan Keuangan');
                });
            }

            // dd($request->all());
            return redirect()->route('submission.employee')->with('success', 'Email berhasil dikirimkan');
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return back()->with('error', $e->getMessage());
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
        $submission = Submission::find($id);

        try {
            if ($submission->status == 2) {
                return redirect()->route('submission.employee')->with('error', 'Submission cannot be deleted');
            }

            $submission->delete();
            return redirect()->route('submission.employee')->with('success', 'Submission deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Submission deleted failed');
        }
    }

    public function upload_receipt(Request $request, $id)
    {
        // dd($request->all());
        $submission = Submission::find($id);
        $validator = $request->validate([
            'receipt_image'  => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:5048'
        ]);

        try {
            $data = [];
            if ($request->file('receipt_image')) {
                $file = $request->file('receipt_image');
                $path = $file->store('images/receipts', 'gcs');

                $data['receipt_image'] = Storage::disk('gcs')->url($path);
            }

            $submission->update($data);
            return redirect()->route('submission.employee')->with('success', 'Upload receipt successfully');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }



    public function submissions_index()
    {
        return view('_employees.submissions.employee_index');
    }

    public function submissions_datatable(Request $request)
    {
        if ($request->ajax()) {
            $submissions = Submission::where('user_id', Auth::id())->orderBy('created_at', 'desc')->with('employee', 'employee.user', 'supervisor')->orderBy('created_at', 'DESC');
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

                    if ($row->validation_supervisor == NULL) {
                        $button .= '<a href="' . route('submissions.show.all', $row->id) . '" class="btn btn-info btn-sm" data-id="' . $row->id . '">
                                        <i class="bx bx-show bx-xs"></i>
                                    </a>
                                    <button title="Validasi"  class="btn btn-primary btn-sm btn-validation" data-id="' . $row->id . '">
                                        <i class="bx bx-check-shield bx-xs" ></i>
                                    </button>
                                    <button title="Reject"  class="btn btn-danger btn-sm btn-rejection" data-id="' . $row->id . '">
                                        <i class="bx bx-x-circle bx-xs" ></i>
                                    </button>';
                    }

                    if ($row->receipt_image != NULL) {
                        $button = '<a title="Bukti" target="_blank" href="' . $row->receipt_image . '" class="btn btn-warning btn-sm btn-receipt" data-id="' . $row->id . '">
                                        <i class="bx bx-receipt bx-xs"></i>
                                    </a>';
                    }

                    return $button;
                })
                ->rawColumns(['_validation_supervisor', '_validation_director', '_validation_finance', '_note', 'action'])
                ->make(true);
        }
    }

    public function submissions_show($id)
    {
        $submission = Submission::find($id);
        $submission->update(['seen_at' => date('Y-m-d H:i:s')]);
        return view('_director.submissions.show', compact('submission'));
    }

    public function submissions_validation(Request $request, $id)
    {
        $submission = Submission::find($id);

        try {
            $submission->update([
                'validation_supervisor' => date('Y-m-d H:i:s'),
                'status'        => 1
            ]);

            $input['description'] = $submission->employee->user->name . ' melakukan pengajuan keuangan untuk ' . $submission->title . ' dengan nominal ' . number_format($submission->nominal) . ' mohon untuk melihat dan konfirmasi pengajuan tersebut pada aplikasi <a href="https://ems.tpm-facility.com">https://ems.tpm-facility.com</a><br><br>Terima Kasih';
            $input['subject'] = 'Pengajuan Keuangan ' . $submission->title . ' dari ' . $submission->employee->user->name;

            // $input['email'] = 'rekha.kisnawaty@tpm-facility.com';
            // $input['name'] = 'Rekha Kisnawaty';
            $input['email'] = 'prasojo.utomo@tpm-facility.com';
            $input['name'] = 'Prasojo Utomo';

            Mail::send('email.send_announcement', $input, function ($message) use ($input) {
                $message->to($input['email'], $input['name'])->subject($input['subject']);
            });

            return redirect()->route('submissions.all')->with('success', 'Submission validation successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Submission validation failed');
        }
    }

    public function submissions_rejection(Request $request, $id)
    {
        // dd($id);
        $submission = Submission::find($id);

        try {
            $submission->update([
                'status'        => 3
            ]);
            // dd($submission);
            return redirect()->route('submissions.all')->with('success', 'Submission rejection successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Submission rejection failed');
        }
    }

    public function submissions_pending(Request $request, $id)
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
            return redirect()->route('submissions.all')->with('success', 'Submission pending successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', $th->getMessage());
        }
    }
}
