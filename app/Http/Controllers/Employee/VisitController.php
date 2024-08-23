<?php

namespace App\Http\Controllers\Employee;

use App\Helpers\CompareDistance;
use App\Models\Visit;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\VisitCategory;
use Illuminate\Support\Facades\File;

class VisitController extends Controller
{
    public function index()
    {
        $sites = Site::all();
        $categories = VisitCategory::all();
        return view('_employees.visits.index', compact('sites', 'categories'));
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $visits = Visit::with('employee', 'site', 'employee.user', 'category')->where('employee_id', auth()->user()->employee->id)->latest();

            if (!empty($request->site_id)) {
                $visits = $visits->where('site_id', $request->site_id);
            }

            if (!empty($request->date)) {
                $visits = $visits->whereDate('created_at', '=', $request->date);
            }

            $visits->get();
            return DataTables::of($visits)
                ->addColumn('map', function ($row) {
                    return '<a href ="http://maps.google.com/maps?q=' . $row->latitude . ',' . $row->longitude . '" target="_blank">
                           Click To Location </a>';
                })

                ->addColumn('_site', function ($row) {
                    if ($row->site_id == NULL) {
                        return 'Tidak ada Site';
                    } else {
                        return $row->site->name;
                    }
                })

                ->addColumn('_status', function ($row) {
                    if ($row->status == 0) {
                        return '<span class="badge bg-info">CheckIn</span>';
                    } else {
                        return '<span class="badge bg-danger">CheckOut</span>';
                    }
                })

                ->addColumn('action', function ($row) {
                    $button = '';

                    $button .= '<button class="btn btn-info btn-sm btn-upload" data-id="' . $row->id . '">
                                    <i class="bx bx-cloud-upload"></i> Upload File
                                </button>';

                    if ($row->file != NULL) {
                        $button .= '<button class="btn btn-soft-info btn-sm ms-1 btn-view-file"  data-file="' . asset('images/visits/' . $row->file) . '" data-id="' . $row->id . '">
                                        <i class="bx bx-file"></i> View File
                                    </button>';
                    }

                    return $button;
                })

                ->rawColumns(['map', '_status', 'action', '_site'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        // dd($request);
        $validator = $request->validate([
            'visit_category_id'    => 'required',
            'keterangan'    => 'required',
            'longitude'     => 'required',
            'latitude'      => 'required',
            'status'        => 'required',
        ]);

        try {
            $status = 0;
            $site_id = NULL;

            if ($request->site_uid != "" || $request->site_uid != NULL) {
                $site = Site::where('uid', $request->site_uid)->first();
                $site_id = $site->id;
            }

            $visit = Visit::create([
                'employee_id'           => auth()->user()->employee->id,
                'site_id'               => $site_id,
                'longitude'             => $request->longitude,
                'latitude'              => $request->latitude,
                'visit_category_id'     => $request->visit_category_id,
                'keterangan'            => $request->keterangan,
                'status'                => $request->status
            ]);

            return redirect()->route('visits.employee')->with('success', 'attendance created successfully');
        } catch (\Exception $th) {
            return back()->with('error', $th);
        }
    }

    public function getSite(Request $request)
    {
        $site = Site::where('uid', $request->uid)->first();

        if (is_null($site)) {
            return response()->json([
                'success' => false,
                'message' => 'Site Not Found'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $site
        ]);
    }

    public function getDistance(Request $request)
    {
        $site = Site::where('uid', $request->uid)->first();
        $compare = CompareDistance::getDistance($request->lat, $request->long, $site->latitude, $site->longitude);
        $distance = $compare['meters'];
        $unit = 'm';

        if (is_null($site)) {
            return response()->json([
                'success' => false,
                'message' => 'Site Not Found'
            ]);
        }

        if ($distance > 1000) {
            $distance = $compare['kilometers'];
            $unit = 'Km';
        }

        return response()->json([
            'success' => true,
            'distance' => intval($distance) . ' ' . $unit
        ]);
    }

    public function upload(Request $request)
    {
        $validate = $request->validate([
            'file' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:3072'
        ]);

        try {
            $absent = Visit::find($request->id);

            if ($request->file('file')) {
                $file = $request->file('file');
                $data['file'] = date('YmdHis') . '.' . $file->extension();

                $destinationPath = public_path('images/visits/');
                $file->move($destinationPath, $data['file']);

                if ($absent->file != NULL) {
                    File::delete('images/visits/' . $absent->file);
                }
            }

            $absent->update($data);
            return redirect()->route('visits.employee')->with('success', 'Upload file successfully');
        } catch (\Throwable $th) {
            return back()->with('error', 'Upload file failed');
        }
    }
}
