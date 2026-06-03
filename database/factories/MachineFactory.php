<?php

namespace Database\Factories;

use App\Models\Filiere;
use App\Models\Machine;
use Illuminate\Database\Eloquent\Factories\Factory;

class MachineFactory extends Factory
{
    protected $model = Machine::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word() . ' ' . $this->faker->randomElement(['X2000', 'Pro', 'ELITE', 'Classic']),
            'filiere_id' => Filiere::inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement(['fonctionnelle', 'en_panne', 'en_maintenance']),
        ];
    }
}