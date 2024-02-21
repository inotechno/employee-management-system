<?php

namespace Database\Seeders;

use App\Models\VisitCategory;
use Illuminate\Database\Seeder;

class VisitCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VisitCategory::create([
            'name' => 'Management Meeting',
        ]);

        VisitCategory::create([
            'name' => 'Patroli',
        ]);

        VisitCategory::create([
            'name' => 'Koordinasi',
        ]);
    }
}
