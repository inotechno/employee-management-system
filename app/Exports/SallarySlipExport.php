<?php

namespace App\Exports;

use App\Models\Employee;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SallarySlipExport implements FromView
{
    public function view(): View
    {
        return view('exports.sallary_slip', [
            'employees' => Employee::where('status', 1)->get()
        ]);
    }
}
