<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelHasRole extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = 'database/model_has_roles.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('model has roles table seeded!');
    }
}
