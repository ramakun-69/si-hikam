<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        User::create([
            'username' => 'administrator',
            'password' => 'admin123',    
            'role' => 'admin',
        ]);
    }
}
