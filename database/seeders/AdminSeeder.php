<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrateur Principal',
            'email' => 'admin', 
            'password' => Hash::make('fama2026'),
            'role' => 'admin',
            'poste' => 'Commandement',
            'is_active' => true,
        ]);
    }
}