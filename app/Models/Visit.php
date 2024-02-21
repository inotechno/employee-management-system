<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'site_id', 'latitude', 'longitude', 'status', 'keterangan', 'visit_category_id', 'file'];


    /**
     * Get the employee that owns the Leave
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * Get the category that owns the Visit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(VisitCategory::class, 'visit_category_id');
    }
}
