<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Project extends Model
{
    use HasFactory,SoftDeletes;


    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'project_manager_id',
        'status',
        'created_by',
        'updated_by'
    ];

    public function members(){
        return $this->belongsToMany(User::class, 'user_project', 'project_id', 'user_id');
    }

    public function tasks(){
        return $this->hasMany(Task::class,'project_id');
    }

    public function projectManager()
    {
        return $this->belongsTo(User::class, 'project_manager_id');
    }

    public function membersExceptManager()
    {
        return $this->members()->where('users.id', '!=', $this->project_manager_id);
    }

    public function getProjectPeriodAttribute()
    {
        $startDate = Carbon::parse($this->attributes['start_date']);
        $endDate = Carbon::parse($this->attributes['end_date']);

        $diff =  $endDate->diff($startDate);

        $format = [];

        if ($diff->y > 0) {
            $format[] = '%y year';
        }

        if ($diff->m > 0) {
            $format[] = '%m month';
        }

        if ($diff->d > 0) {
            $format[] = '%d day';
        }

        return $diff->format(implode(', ', $format));
    }
}
