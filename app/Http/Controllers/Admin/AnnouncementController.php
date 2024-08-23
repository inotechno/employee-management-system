<?php

namespace App\Http\Controllers\Admin;

use App\Models\Announcement;
use App\Http\Controllers\Controller;
use App\Jobs\SendMailAnnouncement;
use App\Mail\SendAnnouncement;
use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('announcements.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('announcements.create');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            // $store = Store::where('user_id', auth()->user()->id)->first();
            $announcements = Announcement::query();
            // dd($order);
            return DataTables::eloquent($announcements)
                ->addIndexColumn()
                ->addColumn('_description', function ($row) {
                    return Str::limit($row->description, 50);
                })
                ->addColumn('action', function ($row) {
                    return '<button data-id="' . $row->id . '" class="btn btn-info btn-sm btn-send">
                               <i class="bx bxs-send" ></i>
                            </button>
                            <a class="btn btn-warning btn-sm" href="' . route('announcements.edit', $row->id) . '">
                               <i class="bx bx-edit-alt" ></i>
                            </a>
                            <button class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '">
                               <i class="bx bx-trash"></i>
                            </button>';
                })
                ->rawColumns(['action'])
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
            'subject'  => 'required',
            'description'  => 'required',
        ]);

        try {
            // $data = Employee::whereIn('id', [20221224])->get();
            $data = Employee::where('status', 1)->get();

            $succes = [];
            foreach ($data as $key => $value) {
                if ($value->user->email != null) {
                    $input['description'] = $request->description;
                    $input['subject'] = $request->subject;
                    $input['email'] = $value->user->email;
                    $input['name'] = $value->user->name;

                    Mail::send('email.send_announcement', $input, function ($message) use ($input) {
                        $message->to($input['email'], $input['name'])->subject($input['subject']);
                    });

                    $succes[] = [
                        'type' => 'success',
                        'name'  => $value->user->email
                    ];
                } else {
                    $succes[] = [
                        'type' => 'error',
                        'message'  => 'Tidak ada email dari ' . $value->user->name
                    ];
                }

                // Mail::to($value->user->email)->send(new SendAccountMail($value));
            }

            Announcement::create($validator);
            return redirect()->route('announcements')->with('success', 'Announcement added successfully');
        } catch (\Exception $th) {
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
        $announcement = Announcement::find($id);
        return view('announcements.edit', compact('announcement'));
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
        $announcement = Announcement::find($id);

        $validator = $request->validate([
            'subject'  => 'required',
            'description'  => 'required',
        ]);

        try {
            $announcement->update($validator);
            return redirect()->route('announcements')->with('success', 'Announcement updated successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Announcement updated failed');
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
        $announcement = Announcement::find($id);
        try {
            $announcement->delete();
            return redirect()->route('announcements')->with('success', 'Announcement deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Announcement deleted failed');
        }
    }

    public function send($id)
    {
        try {
            // $data = Employee::whereIn('id', [20221224])->get();
            $data = Employee::where('status', 1)->get();
            $announcement = Announcement::find($id);
            // dd($data);
            $succes = [];
            foreach ($data as $key => $value) {
                if ($value->user->email != null) {
                    $input['description'] = $announcement->description;
                    $input['subject'] = $announcement->subject;
                    $input['email'] = $value->user->email;
                    $input['name'] = $value->user->name;

                    SendMailAnnouncement::dispatch($input);
                    // Mail::send('email.send_announcement', $input, function ($message) use ($input) {
                    //     $message->to($input['email'], $input['name'])->subject($input['subject']);
                    // });

                    $succes[] = [
                        'type' => 'success',
                        'name'  => $value->user->email
                    ];
                } else {
                    $succes[] = [
                        'type' => 'error',
                        'message'  => 'Tidak ada email dari ' . $value->user->name
                    ];
                }

                // Mail::to($value->user->email)->send(new SendAccountMail($value));
            }

            return redirect()->route('announcements')->with('success', 'Send Announcement successfully');
        } catch (\Exception $th) {
            //throw $th;
            return back()->with('error', $th->getMessage());
        }
    }
}
