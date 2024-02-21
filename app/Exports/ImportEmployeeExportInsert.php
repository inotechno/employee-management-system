<?php

namespace App\Exports;

use App\Models\Employee;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class ImportEmployeeExportInsert implements FromView
{
    public function view(): View
    {
        return view('exports.import_data_insert');
    }
}
