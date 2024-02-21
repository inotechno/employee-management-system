<?php

namespace App\Http\Controllers\Director;

use App\Models\Site;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class SiteController extends Controller
{
    public function index()
    {
        return view('_director.sites.index');
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

                ->rawColumns(['map', 'foto', 'qr_code'])
                ->make(true);
        }
    }
}
