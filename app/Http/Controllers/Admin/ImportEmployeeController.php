<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ImportEmployeeExport;
use App\Exports\ImportEmployeeExportInsert;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportEmployeeImport;
use DateTime;
use Illuminate\Support\Facades\Hash;

class ImportEmployeeController extends Controller
{
    protected $employee;

    public function __construct()
    {
        // dd($this->employee);

        //QUERY UNTUK MENGAMBIL SELURUH DATA USER
        $this->employee = Employee::select('id', 'user_id', 'status')->with('user', function ($query) {
            $query->select('id', 'name', 'email');
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
        return view('employees.importData');
    }

    public function preview_upload(Request $request)
    {
        // dd($request);

        $request->validate([
            'file' => 'required',
        ]);

        $rows = Excel::toCollection(new ImportEmployeeImport, $request->file);
        // dd($rows);
        $data = array();

        foreach ($rows[0] as $r => $row) {

            if (!is_null($row['tanggal_join'])) {
                if (is_numeric($row['tanggal_join'])) {
                    // Jika ini adalah nilai numerik, perlakukan sebagai tanggal Excel
                    $dateTimeJoin = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_join']);
                    $data['rows'][$r]['join_date'] = $dateTimeJoin ? $dateTimeJoin->format('Y-m-d') : null;
                } else {
                    // Jika ini adalah string, perlakukan sebagai format 'Y-m-d'
                    $dateTimeJoin = DateTime::createFromFormat('Y-m-d', $row['tanggal_join']);
                    $data['rows'][$r]['join_date'] = $dateTimeJoin ? $dateTimeJoin->format('Y-m-d') : null;
                }
            } else {
                $data['rows'][$r]['join_date'] = null;
            }

            if (!is_null($row['tanggal_lahir'])) {
                if (is_numeric($row['tanggal_lahir'])) {
                    // Jika ini adalah nilai numerik, perlakukan sebagai tanggal Excel
                    $dateTimeJoin = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir']);
                    $data['rows'][$r]['tanggal_lahir'] = $dateTimeJoin ? $dateTimeJoin->format('Y-m-d') : null;
                } else {
                    // Jika ini adalah string, perlakukan sebagai format 'Y-m-d'
                    $dateTimeJoin = DateTime::createFromFormat('Y-m-d', $row['tanggal_lahir']);
                    $data['rows'][$r]['tanggal_lahir'] = $dateTimeJoin ? $dateTimeJoin->format('Y-m-d') : null;
                }
            } else {
                $data['rows'][$r]['tanggal_lahir'] = null;
            }

            $employee = $this->employee->where('id', $row['employee_id'])->first();

            $data['rows'][$r]['employee_id']                = $row['employee_id'];
            $data['rows'][$r]['name']                       = $row['name'];
            $data['rows'][$r]['email']                      = $row['email'];
            $data['rows'][$r]['tempat_lahir']               = $row['tempat_lahir'] ?? NULL;
            $data['rows'][$r]['bpjs_kesehatan']             = $row['bpjs_kesehatan'];
            $data['rows'][$r]['bpjs_ketenagakerjaan']       = $row['bpjs_ketenagakerjaan'];
            $data['rows'][$r]['nama_rekening']              = $row['nama_rekening'];
            $data['rows'][$r]['no_rekening']                = $row['no_rekening'];
            $data['rows'][$r]['pemilik_rekening']           = $row['pemilik_rekening'];
            $data['rows'][$r]['jumlah_cuti']                = $row['jumlah_cuti'];

            if ($employee) {
                $data['rows'][$r]['id']                     = $employee->user->id;
            } else {
                $data['rows'][$r]['id']                     = 'new';
            }
        }

        // dd($data);

        return view('employees.importData', compact('data'));
    }

    public function download_template()
    {
        return Excel::download(new ImportEmployeeExport, 'Update Masal Employee.xlsx');
    }

    public function download_template_insert()
    {
        return Excel::download(new ImportEmployeeExportInsert, 'Insert Masal Employee.xlsx');
    }

    public function process_upload(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'imports.*.name' => 'required',
        ]);

        try {

            foreach ($request->imports as $key => $value) {
                if ($value['id'] == 'new') {
                    $user = User::create([
                        'name' => $value['name'],
                        'username' => $value['employee_id'],
                        'password' => Hash::make($value['employee_id']),
                        'email' => $value['email'] ?? ''
                    ]);

                    $empl['id']                    = $value['employee_id'];
                    $empl['user_id']               = $user->id;
                    $empl['nama_rekening']         = empty($value['nama_rekening']) ? NULL : $value['nama_rekening'];
                    $empl['no_rekening']           = empty($value['no_rekening']) ? NULL : $value['no_rekening'];
                    $empl['pemilik_rekening']      = empty($value['pemilik_rekening']) ? NULL : $value['pemilik_rekening'];
                    $empl['join_date']             = empty($value['join_date']) ? NULL : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value['tanggal_lahir'])->format('Y-m-d');
                    $empl['tanggal_lahir']         = empty($value['tanggal_lahir']) ? NULL : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value['tanggal_lahir'])->format('Y-m-d');
                    $empl['tempat_lahir']          = empty($value['tempat_lahir']) ? NULL : $value['tempat_lahir'];
                    $empl['bpjs_kesehatan']        = empty($value['bpjs_kesehatan']) ? NULL : $value['bpjs_kesehatan'];
                    $empl['bpjs_ketenagakerjaan']  = empty($value['bpjs_ketenagakerjaan']) ? NULL : $value['bpjs_ketenagakerjaan'];
                    $empl['jumlah_cuti']           = $value['jumlah_cuti'];

                    Employee::create($empl);
                } else {
                    $user = User::find($value['id']);

                    $data = [];
                    $data['name'] = $value['name'];
                    $data['email'] = $value['email'];
                    $user->update($data);

                    $empl = [];
                    $empl['nama_rekening']         = $value['nama_rekening'];
                    $empl['no_rekening']           = $value['no_rekening'];
                    $empl['pemilik_rekening']      = $value['pemilik_rekening'];
                    $empl['join_date']             = $value['join_date'];
                    $empl['tanggal_lahir']         = $value['tanggal_lahir'];
                    $empl['tempat_lahir']          = $value['tempat_lahir'];
                    $empl['bpjs_kesehatan']        = $value['bpjs_kesehatan'];
                    $empl['bpjs_ketenagakerjaan']  = $value['bpjs_ketenagakerjaan'];
                    $empl['jumlah_cuti']           = $value['jumlah_cuti'];

                    $user->employee->update($empl);
                }
            }

            return redirect()->route('import_data.employee')->with('success', 'Imported successfully');
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->route('import_data.employee')->with('error', $e->getMessage());
        }
    }
}
