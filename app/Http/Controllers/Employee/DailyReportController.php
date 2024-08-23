<?php

namespace App\Http\Controllers\Employee;

use App\Models\DailyReport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Mail\DailyReportMail;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DailyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('_employees.daily_reports.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $daily_report = DailyReport::where('employee_id', Auth::user()->employee->id)->latest()->first();
        $employees = Employee::where('status', 1)->get();
        return view('_employees.daily_reports.create', compact('employees', 'daily_report'));
    }

    public function send_email($id)
    {
        $daily_report = DailyReport::find($id);
        return view('_employees.daily_reports.send_email', compact('daily_report'));
    }

    function send_daily_email(Request $request, $id)
    {
        $validator = $request->validate([
            'email'          => 'required|email:rfc,dns',
            'cc'            => 'nullable',
        ]);

        // $ccEmails = ["demo@gmail.com", "demo2@gmail.com"];
        // dd($request->cc);

        $daily_report = DailyReport::with('employee.user')->find($id);
        $request['from'] = $daily_report->employee->user->email;
        $request['name'] = $daily_report->employee->user->name;

        $request['description'] = $daily_report->description;
        // $cc = ['email@esomething.com', 'email1@esomething.com','email2@esomething.com'];
        try {
            if (empty($request->cc)) {
                Mail::to($request->email)->send(new DailyReportMail($request));
            } else {
                Mail::cc($request->cc)->to($request->email)->send(new DailyReportMail($request));
            }

            // dd($request->where('status', 1)->get());
            return redirect()->route('daily_reports.employee')->with('success', 'Email berhasil dikirimkan');
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }

    public function datatable(Request $request)
    {
        // dd($request);
        if ($request->ajax()) {
            // $store = Store::where('user_id', auth()->user()->id)->first();
            $attendances = DailyReport::orderBy('date', 'desc')->where('employee_id', auth()->user()->employee->id);
            // dd($attendances);
            return DataTables::eloquent($attendances)
                ->addIndexColumn()
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('date'))) {
                        return $instance->collection = $instance
                            ->whereDate('date', $request->get('date'));
                    }
                })
                ->addColumn('_description', function ($row) {
                    return Str::limit($row->description, 50);
                })
                ->addColumn('_status', function ($row) {
                    if ($row->seen_at != NULL)
                        return '<span class="badge bg-info">Dibaca</span>';

                    return '<span class="badge bg-warning">Belum dibaca</span>';
                })
                ->addColumn('action', function ($row) {
                    return '<a class="btn btn-warning btn-sm" href="' . route('daily_reports.edit.employee', $row->id) . '">
                               <i class="bx bx-edit-alt" ></i>
                            </a>
                            <a class="btn btn-info btn-sm" href="' . route('daily_reports.show.employee', $row->id) . '">
                               <i class="bx bx-show" ></i>
                            </a>
                            <a class="btn btn-secondary btn-sm" href="' . route('daily_reports.send_email.employee', $row->id) . '">
                               <i class="bx bx-send" ></i>
                            </a>
                            <button class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '">
                               <i class="bx bx-trash"></i>
                            </button>';
                })
                ->rawColumns(['action', '_description', '_status'])
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
        // dd($request->file('media'));
        $date = Carbon::now()->subDays(3);
        $validator = $request->validate([
            'date'          => 'required|date|after_or_equal:' . $date . '|before:tomorrow',
            'description'   => 'required|min:10',
        ]);


        // dd(intval(date('d', strtotime($request->date))));
        $validator['employee_id'] = auth()->user()->employee->id;
        $validator['day']         = intval(date('d', strtotime($request->date)));

        $request['from'] = auth()->user()->email;
        $request['name'] = auth()->user()->name;

        try {

            $daily_report = DailyReport::create($validator);

            if ($medias = $request->file('media')) {
                foreach ($medias as $media) {
                    $daily_report->addMedia($media)->toMediaCollection('media');
                }
            }

            if (!empty($request->cc)) {
                $daily_report->users()->sync($request->cc);
                // Mail::cc($request->cc)->to($request['from'])->send(new DailyReportMail($request));
                // $validator['cc'] = implode(',', $request->cc);
            }
            // dd($validator);
            activity()->log('Tambah daily report');
            return redirect()->route('daily_reports.employee')->with('success', 'Daily report added successfully');
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
        $daily_report = DailyReport::find($id);
        // dd($daily_report);
        $daily_report->comment()->update(['seen_at' => date('Y-m-d H:i:s')]);
        return view('_employees.daily_reports.show', compact('daily_report'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $daily_report = DailyReport::find($id);
        $employees = Employee::where('status', 1)->get();
        // dd($daily_report->getMedia('media'));
        return view('_employees.daily_reports.edit', compact('daily_report', 'employees'));
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
        // dd($request);
        $daily_report = DailyReport::find($id);

        $validator = $request->validate([
            'date'          => 'required|date',
            'description'   => 'required|min:10',
        ]);

        // if (!empty($request->cc)) {
        //     Mail::cc($request->cc)->to($request['from'])->send(new DailyReportMail($request));
        //     $validator['cc'] = $request->cc;
        // }

        try {
            $daily_report->update($validator);

            if ($media = $request->file('media')) {
                $daily_report->clearMediaCollection('media');
                foreach ($media as $image) {
                    $daily_report->addMedia($image)->toMediaCollection('media');
                }
            }

            if (!empty($request->cc)) {
                $daily_report->users()->sync($request->cc);
                // Mail::cc($request->cc)->to($request['from'])->send(new DailyReportMail($request));
                // $validator['cc'] = implode(',', $request->cc);
            }
            return redirect()->route('daily_reports.employee')->with('success', 'Daily report updated successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Daily report updated failed');
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
        $daily_report = DailyReport::find($id);

        try {
            $daily_report->delete();
            return redirect()->route('daily_reports.employee')->with('success', 'Daily report deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Daily report deleted failed');
        }
    }
}
