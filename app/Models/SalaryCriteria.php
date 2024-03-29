<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryCriteria extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating_point',
        'bonus_amount'
    ];
}
