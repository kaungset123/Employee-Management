<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'date' => 'datetime',
        'clock_in' => 'datetime',
        'clock_out' => 'datetime',
    ];

    protected $fillable = [
        'id',
        'date',
        'clock_in',
        'clock_out',
        'user_id',
        'overtime',
        'status',
        'created_by'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function department()
    {
        return $this->user->department;
        // return $this->user ? $this->user->department : null;
    }
}
