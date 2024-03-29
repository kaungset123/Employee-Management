<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    protected $dates = ['start_date', 'end_date'];

    protected $fillable = [
        'name',
        'description',
        'project_id',
        'user_id',
        'start_date',
        'end_date',
        'created_by',
        'created_by',
        'updated_by'
    ];


    public function project(){
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

}
