<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            FiliereSeeder::class,
            UserSeeder::class,
            MachineSeeder::class,
            MaintenanceSeeder::class,
        ]);
    }
}