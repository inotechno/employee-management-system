<?php

namespace App\Exports;

use App\Models\Employee;
use DateTime;
use Exception;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportEmployeeExport implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting
{
    use Exportable;
    private $rowNumber = 0;

    public function query()
    {
        return Employee::query()->where('status', 1);
    }

    public function headings(): array
    {
        return [
            'NO',
            'EMPLOYEE ID',
            'NAME',
            'EMAIL',
            'TANGGAL JOIN',
            'TANGGAL LAHIR',
            'TEMPAT LAHIR',
            'BPJS KESEHATAN',
            'BPJS KETENAGAKERJAAN',
            'NAMA REKENING',
            'NO REKENING',
            'PEMILIK REKENING',
            'JUMLAH CUTI ',
        ];
    }

    public function map($employee): array
    {
        try {
            if ($employee->join_date != NULL) {
                $joinDate = new DateTime($employee->join_date);
                $joinDateExcelValue = Date::dateTimeToExcel($joinDate);
            } else {
                $joinDateExcelValue = null;
            }
        } catch (Exception $e) {
            // Handle error, misalnya dengan logging atau set nilai default
            $joinDateExcelValue = null;
            // Log error atau beri tahu admin sistem
        }

        try {
            if ($employee->tanggal_lahir != NULL) {
                $tanggalLahir = new DateTime($employee->tanggal_lahir);
                $tanggalLahirExcelValue = Date::dateTimeToExcel($tanggalLahir);
            } else {
                $tanggalLahirExcelValue = null;
            }
        } catch (Exception $e) {
            // Handle error, misalnya dengan logging atau set nilai default
            $tanggalLahirExcelValue = null;
            // Log error atau beri tahu admin sistem
        }

        $this->rowNumber++; // Tingkatkan nomor baris setiap kali method map dipanggil

        return [
            $this->rowNumber,
            $employee->id,
            $employee->user->name,
            $employee->user->email,
            $joinDateExcelValue,
            $tanggalLahirExcelValue,
            $employee->tempat_lahir,
            $employee->bpjs_kesehatan,
            $employee->bpjs_ketenagakerjaan,
            $employee->nama_rekening,
            $employee->no_rekening,
            $employee->pemilik_rekening,
            $employee->jumlah_cuti,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,  // Format untuk kolom Tanggal Lahir
        ];
    }

    // public function view(): View
    // {
    //     return view('exports.import_data', [
    //         'employees' => Employee::where('status', 1)->get()
    //     ]);
    // }
}
