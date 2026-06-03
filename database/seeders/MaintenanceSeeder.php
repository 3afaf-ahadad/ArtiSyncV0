<?php

namespace Database\Seeders;

use App\Models\Maintenance;
use App\Models\Machine;
use Illuminate\Database\Seeder;

class MaintenanceSeeder extends Seeder
{
    public function run()
    {
        $machines = Machine::all();
        foreach ($machines as $machine) {
            if (rand(1, 10) <= 7) {
                Maintenance::factory(rand(1, 4))->create(['machine_id' => $machine->id]);
            }
        }
    }
}