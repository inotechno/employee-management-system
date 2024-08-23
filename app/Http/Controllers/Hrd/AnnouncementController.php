<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;


class AnnouncementController extends Controller
{
    public function index()
    {
        return view('_hrd.announcements.index');
    }

    public function create()
    {
        return view('_hrd.announcements.create');
    }

    public function datatable(Request $request)
    {
        // dd($request);
        if ($request->ajax()) {
            $announcements = Announcement::query();
            // dd($attendances);
            return DataTables::eloquent($announcements)
                ->addIndexColumn()

                ->addColumn('_description', function ($row) {
                    return Str::limit($row->description, 50);
                })
                ->addColumn('action', function ($row) {
                    return '<a class="btn btn-warning btn-sm" href="' . route('announcements.edit.hrd', $row->id) . '">
                               <i class="bx bx-edit-alt" ></i>
                            </a>
                            <button class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '">
                               <i class="bx bx-trash"></i>
                            </button>';
                })
                ->rawColumns(['action', '_description'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        // dd($request);
        $validator = $request->validate([
            'subject'  => 'required',
            'description'    => 'required|min:10',
        ]);


        try {
            Announcement::create($validator);
            return redirect()->route('announcements.hrd')->with('success', 'Announcements added successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error');
        }
    }

    public function edit($id)
    {
        $announcement = Announcement::find($id);
        return view('_hrd.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        $announcement = Announcement::find($id);

        $validator = $request->validate([
            'subject'  => 'required',
            'description'    => 'required|min:10',
        ]);

        try {
            $announcement->update($validator);
            return redirect()->route('announcements.hrd')->with('success', 'Announcements updated successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Announcements updated failed');
        }
    }

    public function destroy($id)
    {
        $announcement = Announcement::find($id);

        try {
            $announcement->delete();
            return redirect()->route('announcements.hrd')->with('success', 'Announcement deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Announcement deleted failed');
        }
    }
}
