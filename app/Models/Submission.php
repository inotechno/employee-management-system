<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'title', 'nominal', 'note', 'user_id', 'validation_supervisor', 'validation_director', 'validation_finance', 'status', 'receipt_image', 'seen_at'];

    /**
     * Get the employee that owns the Submission
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
