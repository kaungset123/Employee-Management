<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'date_of_birth',
        'gender',
        'address',
        'basic_salary',
        'ot_rate',
        'hourly_rate',
        'img',
        'department_id',
        'created_by',
        'updated_by'
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
        'created_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function attendances(){
        return $this->hasMany(Attendance::class, 'user_id');
    }

    public function salarys(){
        return $this->hasMany(SalaryDetail::class, 'user_id');
    }

    public function rateUser(){
        return $this->hasMany(Rating::class, 'rater_id');
    }

    public function ratedUser(){
        return $this->hasMany(Rating::class, 'rated_id');
    }

    public function projects(){
        return $this->belongsToMany(Project::class, 'user_project');
    }

    public function tasks(){
        return $this->hasMany(Task::class, 'user_id');
    }

    public function leaves(){
        return $this->hasMany(Leave::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }
    
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
