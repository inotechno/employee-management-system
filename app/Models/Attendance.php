<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['uid', 'employee_id', 'state', 'latitude', 'longitude', 'timestamp', 'type', 'keterangan', 'event_id', 'site_id', 'photo'];

    public function scopeByEmployeeAndDate($query, $employeeId, $date, $startTime, $endTime)
    {
        return $query->whereTime('timestamp', '>=', $startTime)
            ->whereTime('timestamp', '<=', $endTime)
            ->whereDate('timestamp', $date)
            ->where('employee_id', $employeeId)
            ->orderBy('timestamp', 'ASC');
    }
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
