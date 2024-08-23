<?php

namespace App\Http\Controllers\Admin;

use App\Models\Employee;
use App\Models\SallarySlip;
use Illuminate\Http\Request;
use App\Exports\SallarySlipExport;
use App\Imports\SallarySlipImport;
use App\Models\PeriodeSallarySlip;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class SallarySlipController extends Controller
{

    public function history()
    {
        $periodes = PeriodeSallarySlip::all();
        return view('sallary_slips.history', compact('periodes'));
    }

    public function datatable(Request $request)
    {
        // dd($request);
        if ($request->ajax()) {
            // $store = Store::where('user_id', auth()->user()->id)->first();
            $sallary_slips = SallarySlip::with('employee', 'employee.user', 'periode');

            if (!empty($request->employee_id)) {
                $sallary_slips = $sallary_slips->where('employee_id', $request->employee_id);
            }

            if (!empty($request->date)) {
                $sallary_slips = $sallary_slips->whereDate('timestamp', '=', $request->date);
            }
            $sallary_slips->get();
            // dd($sallary_slips);
            return DataTables::of($sallary_slips)
                ->addIndexColumn()
                ->addColumn('total_pendapatan', function ($row) {
                    return $row->gaji_pokok + $row->tunj_jabatan + $row->tunj_lain_lain + $row->tunj_makan + $row->tunj_pulsa + $row->tunj_transport + $row->revisi;
                })
                ->addColumn('periode', function ($row) {
                    return date('d M Y', strtotime($row->periode->periode_start)) . ' s/d ' . date('d M Y', strtotime($row->periode->periode_end));
                })
                ->addColumn('total_potongan', function ($row) {
                    return $row->pot_pph21 + $row->pot_bpjs_tk + $row->pot_jaminan_pensiun + $row->pot_bpjs_kesehatan + $row->pot_pinjaman + $row->pot_daily_report + $row->pot_keterlambatan;
                })
                ->rawColumns(['total_pendapatan', 'total_potongan', 'periode'])
                ->make(true);
        }
    }
}
