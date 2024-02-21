<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'user_id', 'position_id', 'card_number', 'join_date', 'tanggal_lahir', 'tempat_lahir', 'bpjs_kesehatan', 'bpjs_ketenagakerjaan', 'status', 'nama_rekening', 'no_rekening', 'pemilik_rekening', 'jumlah_cuti'];

    /**
     * Get the user that owns the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the position that owns the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Get all of the attendance for the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'employee_id', 'id');
    }

    /**
     * Get all of the daily_report for the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function daily_report()
    {
        return $this->hasMany(DailyReport::class);
    }

    /**
     * Get all of the sallary_slip for the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sallary_slip()
    {
        return $this->hasMany(SallarySlip::class);
    }

    /**
     * Get all of the paid_leave for the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paid_leave()
    {
        return $this->hasMany(PaidLeave::class);
    }

    public function absent()
    {
        return $this->hasMany(Absent::class);
    }

    /**
     * Get all of the paid_leave for the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visit()
    {
        return $this->hasMany(Visit::class, 'employee_id', 'id');
    }

    /**
     * Get all of the submission for the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submission()
    {
        return $this->hasMany(Submission::class);
    }
}
