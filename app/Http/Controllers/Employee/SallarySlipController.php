<?php

namespace App\Http\Controllers\Employee;

use PDF;
use App\Models\SallarySlip;
use Illuminate\Http\Request;
use App\Models\PeriodeSallarySlip;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class SallarySlipController extends Controller
{
    public function index()
    {
        $periodes = PeriodeSallarySlip::all();
        return view('_employees.sallary_slips.index', compact('periodes'));
    }

    public function datatable(Request $request)
    {
        // dd($request);
        if ($request->ajax()) {
            // $store = Store::where('user_id', auth()->user()->id)->first();
            $attendances = SallarySlip::with('employee', 'employee.user', 'periode')->where('employee_id', auth()->user()->employee->id);
            // dd($attendances);
            $attendances->get();
            return DataTables::of($attendances)
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
                ->addColumn('action', function ($row) {
                    return '<a class="btn btn-warning btn-sm" href="' . route('sallary_slip.export.employee', $row->id) . '">
                     <i class="bx bxs-file-pdf bx-sm"></i>
                    </a>';
                })
                ->rawColumns(['action', 'total_pendapatan', 'total_potongan', 'periode'])
                ->make(true);
        }
    }

    public function export($id)
    {
        $sallary_slip = SallarySlip::find($id);
        // dd($sallary_slip);
        return view('_employees.sallary_slips.export', compact('sallary_slip'));
        // $pdf = PDF::loadview('_employees.sallary_slips.export');
        // return $pdf->stream();
    }
}
