<?php

namespace App\Http\Controllers\Finance;

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

    protected $employee;

    public function __construct()
    {

        //QUERY UNTUK MENGAMBIL SELURUH DATA USER
        $this->employee = Employee::select('id', 'user_id')->with('user', function ($query) {
            $query->select('id', 'name');
        })->where('status', 1)->get();

        // dd($this->employee);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function upload()
    {
        return view('_finance.sallary_slips.upload');
    }

    public function history()
    {
        $periodes = PeriodeSallarySlip::all();
        return view('_finance.sallary_slips.history', compact('periodes'));
    }

    public function preview_upload(Request $request)
    {
        // dd($request);

        $request->validate([
            'file' => 'required',
            'periode_start' => 'required|date',
            'periode_end'   => 'required|date'
        ]);

        $rows = Excel::toCollection(new SallarySlipImport, $request->file);
        // dd($rows);
        $data = array();
        $data['periode_start'] = $request->periode_start;
        $data['periode_end'] = $request->periode_end;

        foreach ($rows[0] as $r => $row) {
            $employee = $this->employee->where('id', $row['employee_id'])->first();
            $data['rows'][$r]['employee_id']                = $row['employee_id'];
            $data['rows'][$r]['name']                       = $employee->user->name;
            $data['rows'][$r]['gaji_pokok']                 = $row['gaji_pokok'];
            $data['rows'][$r]['tunj_pulsa']                 = $row['tunj_pulsa'];
            $data['rows'][$r]['tunj_jabatan']               = $row['tunj_jabatan'];
            $data['rows'][$r]['tunj_transport']             = $row['tunj_transport'];
            $data['rows'][$r]['tunj_makan']                 = $row['tunj_makan'];
            $data['rows'][$r]['tunj_lain_lain']             = $row['tunj_lain_lain'];
            $data['rows'][$r]['revisi']                     = $row['revisi'];
            $data['rows'][$r]['pot_pph21']                  = $row['pot_pph21'];
            $data['rows'][$r]['pot_bpjs_tk']                = $row['pot_bpjs_tk'];
            $data['rows'][$r]['pot_jaminan_pensiun']        = $row['pot_jaminan_pensiun'];
            $data['rows'][$r]['pot_bpjs_kesehatan']         = $row['pot_bpjs_kesehatan'];
            $data['rows'][$r]['pot_pinjaman']               = $row['pot_pinjaman'];
            $data['rows'][$r]['pot_keterlambatan']          = $row['pot_keterlambatan'];
            $data['rows'][$r]['pot_daily_report']           = $row['pot_daily_report'];
            $data['rows'][$r]['thp']                        = $row['thp'];
            $data['rows'][$r]['jumlah_hari_kerja']          = $row['jumlah_hari_kerja'];
            $data['rows'][$r]['jumlah_sakit']               = $row['jumlah_sakit'];
            $data['rows'][$r]['jumlah_izin']                = $row['jumlah_izin'];
            $data['rows'][$r]['jumlah_alpha']               = $row['jumlah_alpha'];
            $data['rows'][$r]['jumlah_cuti']                = $row['jumlah_cuti'];
        }

        // dd($data);
        return view('_finance.sallary_slips.upload', compact('data'));
    }

    public function process_upload(Request $request)
    {
        $request->validate([
            'imports.*.employee_id' => 'required',
            'periode_start' => 'required',
            'periode_end' => 'required',
        ]);

        // dd($request);
        try {
            $periode = PeriodeSallarySlip::create([
                'periode_start' => $request->periode_start,
                'periode_end' => $request->periode_end,
            ]);

            $value = [];
            foreach ($request->imports as $key => $value) {
                $value['periode_id']    = $periode->id;
                SallarySlip::create($value);
            }

            // dd($value);

            return redirect()->route('sallary_slip.upload.finance')->with('success', 'Imported successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('sallary_slip.upload.finance')->with('error', json_encode($th));
        }
    }

    public function download_template()
    {
        return Excel::download(new SallarySlipExport, 'template.xlsx');
    }

    public function datatable(Request $request)
    {
        // dd($request);
        if ($request->ajax()) {
            // $store = Store::where('user_id', auth()->user()->id)->first();
            $attendances = PeriodeSallarySlip::query();

            if (!empty($request->date)) {
                $attendances = $attendances->whereDate('timestamp', '=', $request->date);
            }

            $attendances->get();

            return DataTables::of($attendances)
                ->addIndexColumn()
                ->addColumn('_count', function ($row) {
                    return $row->sallary_slips->count();
                })
                ->addColumn('_periode', function ($row) {
                    return $row->periode_start . ' - ' . $row->periode_end;
                })
                ->addColumn('_action', function ($row) {
                    return '<button class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '">
                               <i class="bx bx-trash"></i>
                            </button>';
                })
                ->rawColumns(['_action', '_count', '_periode'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $periode = PeriodeSallarySlip::find($id);
        try {
            $periode->sallary_slips()->delete();
            $periode->delete();
            return redirect()->route('sallary_slip.history.finance')->with('success', 'History sallary slip deleted successfully');
        } catch (\Throwable $th) {
            return back()->with('error', 'History sallary slip deleted failed');
        }
    }
}
