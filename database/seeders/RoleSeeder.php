<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'administrator',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'employee',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'hrd',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'finance',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'director',
            'guard_name' => 'web'
        ]);
    }
}
