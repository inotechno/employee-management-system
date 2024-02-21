<?php

namespace Database\Seeders;

use App\Models\Machine;
use Illuminate\Database\Seeder;

class MachineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Machine::create([
            'name' => 'TPM Group',
            'ip' => '192.168.20.221',
            'port' => 4370,
            'active' => 'yes'
        ]);
    }
}
