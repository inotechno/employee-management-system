<?php

namespace Database\Seeders;

use App\Models\EventAttendance;
use Illuminate\Database\Seeder;

class EventAttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EventAttendance::create([
            'name' => 'Tag',
            'slug' => 'tag',
        ]);

        EventAttendance::create([
            'name' => 'QRCode',
            'slug' => 'qrcode',
        ]);

        EventAttendance::create([
            'name' => 'Fingerprint',
            'slug' => 'fingerprint',
        ]);
    }
}
