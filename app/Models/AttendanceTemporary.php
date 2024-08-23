<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceTemporary extends Model
{
    use HasFactory;
    protected $fillable = ['uid', 'employee_id', 'state', 'latitude', 'longitude', 'timestamp', 'type', 'keterangan', 'event_id', 'site_id', 'photo', 'user_id'];

    /**
     * Get the employee that owns the Attendance
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function event()
    {
        return $this->belongsTo(EventAttendance::class);
    }

    /**
     * Get the site that owns the Attendance
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
