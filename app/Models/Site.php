<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'uid', 'name', 'latitude', 'longitude', 'foto', 'qr_code'];

    public function site()
    {
        return $this->hasMany(Site::class);
    }

    /**
     * Get all of the attendances for the Site
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
