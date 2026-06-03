<?php

namespace Database\Seeders;

use App\Models\Filiere;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'name' => 'Chef de Pôle',
            'email' => 'admin@artisync.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'filiere_id' => null,
        ]);

        // Formateur Haute Couture
        $hauteCouture = Filiere::where('name', 'Haute Couture')->first();
        User::create([
            'name' => 'Formateur Couture',
            'email' => 'couture@artisync.com',
            'password' => Hash::make('password'),
            'role' => 'responsable',
            'filiere_id' => $hauteCouture->id,
        ]);
    }
}