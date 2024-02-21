<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DailyReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = 'database/daily_reports.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('daily reports table seeded!');
    }
}
