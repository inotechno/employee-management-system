<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = 'database/visits.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Visit table seeded!');
    }
}
