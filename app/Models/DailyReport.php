<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class DailyReport extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['employee_id', 'date', 'description', 'day', 'cc', 'seen_at'];

    /**
     * Get the employee that owns the DailyReport
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'daily_reports_users');
    }
}
