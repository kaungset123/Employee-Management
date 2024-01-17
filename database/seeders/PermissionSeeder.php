<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'task create']);
        Permission::create(['name' => 'task update']);
        Permission::create(['name' => 'task delete']);
        Permission::create(['name' => 'task restore']);
        Permission::create(['name' => 'task view']);
    }
}
