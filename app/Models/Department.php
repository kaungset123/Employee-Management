<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function users(){
        return $this->hasMany(User::class);
    }

    public function managerName()
    {
        return $this->hasMany(User::class)
            ->select('name')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'manager');
            });
    }
}
