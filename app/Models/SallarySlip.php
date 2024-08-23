<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SallarySlip extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'periode_id',
        'gaji_pokok',
        'tunj_pulsa',
        'tunj_jabatan',
        'tunj_transport',
        'tunj_makan',
        'tunj_lain_lain',
        'revisi',
        'pot_pph21',
        'pot_bpjs_tk',
        'pot_jaminan_pensiun',
        'pot_bpjs_kesehatan',
        'pot_pinjaman',
        'pot_keterlambatan',
        'pot_daily_report',
        'thp',
        'jumlah_hari_kerja',
        'jumlah_sakit',
        'jumlah_izin',
        'jumlah_alpha',
        'jumlah_cuti',
    ];

    /**
     * Get the employee that owns the SallarySlip
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function periode()
    {
        return $this->belongsTo(PeriodeSallarySlip::class);
    }
}
