<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

    {
        Announcement::create([
            'subject' => 'Pengumuman TPM',
            'description' => 'Diberitahukan kepada seluruh karyawan TPM harus mengikuti hadir'
        ]);
    }
}
