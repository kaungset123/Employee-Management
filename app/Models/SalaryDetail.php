<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaryDetail extends Model
{
    use HasFactory,SoftDeletes;

    protected $casts = [
        'created_at' => 'datetime',
    ];

    protected $fillable = [
        'user_id',
        'salary',
        'net_salary',
        'ot_time',
        'ot_amount',
        'leave',
        'dedution',
        'bonus'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
