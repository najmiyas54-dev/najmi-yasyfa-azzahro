<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Guru SMK',
            'nama' => 'Guru SMK',
            'email' => 'guru@smk.com',
            'password' => Hash::make('guru123'),
            'role' => 'admin'
        ]);
    }
}