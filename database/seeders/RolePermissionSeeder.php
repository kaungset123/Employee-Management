<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected static ?string $password;

    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'edit project',
            'delete project',
            'edit user',
            'delete user',
            'view user info'
        ];

        foreach ($permissions as $permission){
            Permission::create([
                'name' => $permission
            ]);
        }

        Role::create(['name'=> 'Super Admin']);

        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Manager']);
        $role3 = Role::create(['name' => 'HR']);
        $role4 = Role::create(['name' => 'Employee']);

        $role2->givePermissionTo('edit user');
        $role2->givePermissionTo('delete user');
        $role2->givePermissionTo('view user info');

        
        $role3->givePermissionTo('edit user');
        $role3->givePermissionTo('delete user');

        $role4->givePermissionTo('view user info');

        $adminPermissions = [
            'edit project',
            'delete project',
            'edit user',
            'delete user',
            'view user info'
        ];

        foreach($adminPermissions as $permission){
            $role1->givePermissionTo($permission);
        }
       

        $user = \App\Models\User::factory()->create([
            'name' => fake()->name(),
            'email' => 'adminexample@gmail.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'phone' => fake()->phoneNumber(),
            'date_of_birth' => fake()->date(),
            'gender' => 'male',
            'address' => fake()->address(),
            'basic_salary' => '600000',
            'ot_rate' => '5000',
            'hourly_rate' => '12000',
        ]);
        $user->assignRole($role1);

        // gets all permissions via Gate::before rule; see AuthServiceProvider
    }
}
