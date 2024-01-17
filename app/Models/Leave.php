<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leave extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    protected $fillable = [
        'name',
        'user_id',
        'start_date',
        'end_date',
        'status',
        'total_days',
        'created_by',
        'updated_by'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function department()
    {
        // return $this->user->department;
        return $this->user ? $this->user->department : null;
    }
}
