<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitCategory extends Model
{
    use HasFactory;

    /**
     * Get all of the visit for the VisitCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visit()
    {
        return $this->hasMany(Visit::class);
    }
}
