<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comment_daily_reports';

    protected $fillable = ['daily_report_id', 'user_id', 'comment'];
    /**
     * Get the employee that owns the DailyReport
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function daily_report()
    {
        return $this->belongsTo(DailyReport::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
