<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SalaryCriteria;

class SalaryCriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        SalaryCriteria::create(['rating_point' => '5', 'bonus_amount' => 500]);
        SalaryCriteria::create(['rating_point' => '4', 'bonus_amount' => 400]);
        SalaryCriteria::create(['rating_point' => '3', 'bonus_amount' => 300]);
        // Add more criteria if needed
    }
}
