<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $admin = User::create([
        //     'name' => 'Administrator',
        //     'username' => 'administrator',
        //     'email' => 'administrator@mindotek.com',
        //     'foto' => null,
        //     'password' => bcrypt('password')
        // ]);

        // $admin->assignRole('administrator');

        // $director = User::create([
        //     'name' => 'Director',
        //     'username' => 'director',
        //     'email' => 'director@mindotek.com',
        //     'foto' => null,
        //     'password' => bcrypt('password')
        // ]);

        // $director->assignRole('director');

        // $hrd = User::create([
        //     'name' => 'HRD',
        //     'username' => 'hrd',
        //     'email' => 'hrd@mindotek.com',
        //     'foto' => null,
        //     'password' => bcrypt('password')
        // ]);

        // $hrd->assignRole('hrd');

        // $finance = User::create([
        //     'name' => 'Finance',
        //     'username' => 'finance',
        //     'email' => 'finance@mindotek.com',
        //     'foto' => null,
        //     'password' => bcrypt('password')
        // ]);

        // $finance->assignRole('finance');

        $path = 'database/users.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('users table seeded!');
    }
}
