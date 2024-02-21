<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absent extends Model
{
    use HasFactory;
    protected $fillable = ['employee_id', 'date', 'description', 'validation_at', 'validation_by', 'status', 'seen_at', 'file'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the validation_at that owns the Absent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function validation_user()
    {
        return $this->belongsTo(User::class, 'validation_by');
    }
}
