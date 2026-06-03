<?php

namespace Database\Factories;

use App\Models\Machine;
use App\Models\Maintenance;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaintenanceFactory extends Factory
{
    protected $model = Maintenance::class;

    public function definition()
    {
        return [
            'machine_id' => Machine::factory(),
            'date' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'description' => $this->faker->sentence(),
        ];
    }
}