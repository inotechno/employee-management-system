<?php

namespace Database\Seeders;

use App\Models\ConfigAttendance;
use Illuminate\Database\Seeder;

class ConfigAttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ConfigAttendance::create([
            'type'  => 'Masuk',
            'start' => '03:00:00',
            'end'   => '12:00:00',
        ]);

        ConfigAttendance::create([
            'type'  => 'Pulang',
            'start' => '12:01:00',
            'end'   => '24:00:00',
        ]);
    }
}
