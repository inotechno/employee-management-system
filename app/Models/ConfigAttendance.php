<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigAttendance extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'time_start', 'time_end'];
}
