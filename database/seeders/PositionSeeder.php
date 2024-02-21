<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::create([
            'name' => 'IT',
            'slug' => 'it'
        ]);

        Position::create([
            'name' => 'Director',
            'slug' => 'Director'
        ]);

        Position::create([
            'name' => 'Marketing',
            'slug' => 'marketing'
        ]);

        Position::create([
            'name' => 'HRD',
            'slug' => 'hrd'
        ]);

        Position::create([
            'name' => 'Office Support',
            'slug' => 'office-support'
        ]);

        Position::create([
            'name' => 'Cleaning Service',
            'slug' => 'cleaning-service'
        ]);

        Position::create([
            'name' => 'Finance',
            'slug' => 'finance'
        ]);

        Position::create([
            'name' => 'Security',
            'slug' => 'security'
        ]);
    }
}
