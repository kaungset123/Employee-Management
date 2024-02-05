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

        $role1 = Role::create(['name'=> 'Super Admin']);

        $role2 = Role::create(['name' => 'Admin']);
        $role3 = Role::create(['name' => 'Manager']);
        $role4 = Role::create(['name' => 'HR']);
        $role5 = Role::create(['name' => 'Employee']);

    
        $user1 = \App\Models\User::factory()->create([
            'name' => 'Mr.Georg',
            'email' => 'superadmin@gmail.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'phone' => fake()->phoneNumber(),
            'date_of_birth' => fake()->date(),
            'gender' => 'male',
            'address' => fake()->address(),
        ]);
        $user1->assignRole($role1);

        $user2 = \App\Models\User::factory()->create([
            'name' => 'Mr.Tony',
            'email' => 'adminexample@gmail.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'phone' => fake()->phoneNumber(),
            'date_of_birth' => fake()->date(),
            'gender' => 'male',
            'address' => fake()->address(),
        ]);
        $user2->syncRoles($role2);

    }
}
