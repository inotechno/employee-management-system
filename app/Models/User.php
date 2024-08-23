<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'foto',
        'password',
        'username'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get all of the leave_validation for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function leave_validation()
    {
        return $this->hasMany(PaidLeave::class, 'validation_by', 'id');
    }

    /**
     * Get the employee associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get all of the validation_absent for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function validation_absent()
    {
        return $this->hasMany(Absent::class, 'validation_by');
    }

    public function daily_reports()
    {
        return $this->belongsToMany(DailyReport::class, 'daily_reports_users');
    }

    /**
     * Get all of the paid_leave for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paid_leave()
    {
        return $this->hasMany(PaidLeave::class, 'user_id');
    }

    public function submission()
    {
        return $this->hasMany(Submission::class, 'user_id');
    }
}
