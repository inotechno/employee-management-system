<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug'
    ];

    /**
     * Get the attendance associated with the EventAttendance
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function attendance()
    {
        return $this->hasOne(Attendance::class);
    }
}
