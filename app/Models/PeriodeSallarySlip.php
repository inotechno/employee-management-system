<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeSallarySlip extends Model
{
    use HasFactory;

    protected $fillable = ['periode_start', 'periode_end'];

    /**
     * Get all of the sallary_slips for the PeriodeSallarySlip
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sallary_slips()
    {
        return $this->hasMany(SallarySlip::class, 'periode_id', 'id');
    }
}
