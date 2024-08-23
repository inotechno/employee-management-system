<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Employee::create([
        //     'user_id' => 2,
        //     'position_id' => 1,
        //     'card_number' => '10292011',
        //     'tanggal_lahir' => '1997-05-25',
        //     'tempat_lahir' => 'Bekasi',
        // ]);

        $path = 'database/employees.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('employees table seeded!');
    }
}
