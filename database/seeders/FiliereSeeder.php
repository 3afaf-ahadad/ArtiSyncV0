<?php

namespace Database\Seeders;

use App\Models\Filiere;
use Illuminate\Database\Seeder;

class FiliereSeeder extends Seeder
{
    public function run()
    {
        $filieres = ['Haute Couture', 'Bijouterie', 'Menuiserie', 'Tapisserie', 'Maroquinerie'];
        foreach ($filieres as $filiere) {
            Filiere::create(['name' => $filiere]);
        }
    }
}