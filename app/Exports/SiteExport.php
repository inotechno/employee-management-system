<?php

namespace App\Exports;

use App\Models\Site;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SiteExport implements FromView
{
    public function view(): View
    {
        return view('exports.sites', [
            'sites' => Site::all()
        ]);
    }
}
