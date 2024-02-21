<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = 'database/attendance.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Attendance table seeded!');
    }
}
