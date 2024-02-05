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
        Permission::create(['name' => 'user create']);
        Permission::create(['name' => 'user update']);
        Permission::create(['name' => 'user delete']);
        Permission::create(['name' => 'user restore']);
        Permission::create(['name' => 'user view']);

        Permission::create(['name' => 'project create']);
        Permission::create(['name' => 'project update']);
        Permission::create(['name' => 'project delete']);
        Permission::create(['name' => 'project restore']);
        Permission::create(['name' => 'project view']);

        Permission::create(['name' => 'task create']);
        Permission::create(['name' => 'task update']);
        Permission::create(['name' => 'task delete']);
        Permission::create(['name' => 'task restore']);
        Permission::create(['name' => 'task view']);

        Permission::create(['name' => 'payroll create']);
        Permission::create(['name' => 'payroll update']);
        Permission::create(['name' => 'payroll delete']);
        Permission::create(['name' => 'payroll restore']);
        Permission::create(['name' => 'payroll view']);

        Permission::create(['name' => 'leave create']);
        Permission::create(['name' => 'leave update']);
        Permission::create(['name' => 'leave delete']);
        Permission::create(['name' => 'leave restore']);
        Permission::create(['name' => 'leave view']);

        Permission::create(['name' => 'attendance create']);
        Permission::create(['name' => 'attendance update']);
        Permission::create(['name' => 'attendance delete']);
        Permission::create(['name' => 'attendance restore']);
        Permission::create(['name' => 'attendance view']);

        Permission::create(['name' => 'department create']);
        Permission::create(['name' => 'department update']);
        Permission::create(['name' => 'department delete']);
        Permission::create(['name' => 'department restore']);
        Permission::create(['name' => 'department view']);

        Permission::create(['name' => 'profile update']);
        Permission::create(['name' => 'profile view']);

        Permission::create(['name' => 'rating create']);

        Permission::create(['name' => 'role view']);
        Permission::create(['name' => 'role update']);

        Permission::create(['name' => 'payrollcriteria update']);

    }

}
