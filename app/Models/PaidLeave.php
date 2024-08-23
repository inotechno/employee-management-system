<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaidLeave extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'tanggal_mulai',
        'tanggal_akhir',
        'description',
        'user_id',
        'validation_supervisor',
        'validation_hrd',
        'validation_director',
        'status',
        'seen_at',
        'total_cuti',
        'sisa_cuti'
    ];

    /**
     * Get the employee that owns the Leave
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the user_validation that owns the Leave
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_validation()
    {
        return $this->belongsTo(User::class, 'validation_by', 'id');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
