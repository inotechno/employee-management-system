<?php

namespace App\Http\Controllers\Admin;

use PDF;
use App\Models\Site;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;

class SiteController extends Controller
{
    public function index()
    {
        return view('sites.index');
    }

    public function create()
    {
        return view('sites.create');
    }

    public function edit($id)
    {
        $site = Site::find($id);
        return view('sites.edit', compact('site'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            // 'foto'     => 'required|image|mimes:png,jpg,jpeg',
            // 'qr_code'     => 'required|image|mimes:png,jpg,jpeg',
            // 'uid'  => 'required',
            'name'     => 'required',
        ]);

        $uid = Str::random(15);

        //upload image
        $foto = NULL;

        $path = public_path('qr_code/sites/' . $uid . '.png');
        QrCode::size(1012)->margin(1)->backgroundColor(255, 255, 255)->format('png')->generate($uid, $path);

        if ($request->file('foto')) {
            $_foto = $request->file('foto');
            $foto = $request->name . '.' . $_foto->extension();

            $destinationPath = public_path('images/sites/');
            $_foto->move($destinationPath, $foto);
        }

        try {
            $sites = Site::create([
                'uid'           => $uid,
                'qr_code'       => $uid . '.png',
                'name'          => $request->name,
                'longitude'     => $request->longitude,
                'latitude'      => $request->latitude,
                'foto'          => $foto
            ]);

            return redirect()->route('sites')->with('success', 'sites added successfully');
        } catch (\Throwable $th) {
            return back()->with('error', 'Sites added failed');
        }
    }

    public function update(Request $request, $id)
    {
        $site = Site::find($id);

        $this->validate($request, [
            // 'foto'     => 'required|image|mimes:png,jpg,jpeg',
            // 'qr_code'  => 'required',
            'name'     => 'required',
        ]);

        //upload image
        $data = [];
        if ($request->file('foto')) {
            $foto = $request->file('foto');
            $data['foto'] = $request->name . '.' . $foto->extension();

            $destinationPath = public_path('images/sites/');
            $foto->move($destinationPath, $data['foto']);
        }

        $data['name'] = $request->name;
        $data['longitude'] = $request->longitude;
        $data['latitude'] = $request->latitude;
        $data['foto'] = $request->foto;

        try {
            $site->update($data);
            return redirect()->route('sites')->with('success', 'sites updated successfully');
        } catch (\Throwable $th) {
            return back()->with('error', 'Sites update failed');
        }
    }


    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $sites = Site::query();

            return DataTables::eloquent($sites)
                ->addIndexColumn()


                ->addColumn('map', function ($row) {
                    if ($row->latitude != null && $row->longitude != null) {
                        return '<a href ="http://maps.google.com/maps?q=' . $row->latitude . ',' . $row->longitude . '" target="_blank">Click To Location </a>';
                    }

                    return 'Tidak ada data';
                })

                ->addColumn('foto', function ($row) {
                    if ($row->foto != null) {
                        $url = asset("images/sites/" . $row->foto);
                        return '<img src="' . $url . '" border="0" width="40" class="img-rounded" align="center" />';
                    }

                    return 'Tidak ada data';
                })

                ->addColumn('qr_code', function ($row) {
                    if ($row->qr_code != null) {
                        $url = asset("qr_code/sites/" . $row->qr_code);
                        return '<img src="' . $url . '" border="0" width="40" class="img-rounded" align="center" />';
                    }

                    return 'Tidak ada data';
                })

                ->addColumn('action', function ($row) {
                    return '<a class="btn btn-warning btn-sm" href="' . route('sites.edit', $row->id) . '">
                               <i class="bx bx-edit-alt" ></i>
                            </a>
                            <button class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '">
                               <i class="bx bx-trash"></i>
                            </button>';
                })

                ->rawColumns(['action', 'map', 'foto', 'qr_code'])
                ->make(true);
        }
    }

    public function destroy($id)
    {
        $site = Site::find($id);

        try {
            File::delete(public_path('qr_code/sites/' . $site->qr_code));
            $site->delete();
            return redirect()->route('sites')->with('success', 'Sites deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Sites deleted failed');
        }
    }

    // public function generate()
    // {
    //     $sites = Site::all();
    //     foreach ($sites as $site) {
    //         QrCode::size(400)->color(255, 255, 255)->backgroundColor(0, 0, 0)->format('png')->generate($site->uid, public_path('qr_code/' . $site->name . '.png'));
    //     }

    //     return redirect()->route('sites')->with('success', 'Sites generate qrcode successfully');
    // }

    public function print()
    {
        $sites = Site::all();
        return redirect()->route('sites')->with('success', 'Sites generate qrcode successfully');
    }
}
