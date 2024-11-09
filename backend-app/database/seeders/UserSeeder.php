<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'User',
            'middle_name' => 'Middle',
            'last_name' => 'Test',
            'email' => 'test@example.com',
            'phone_number' => '11111111111',
            'rank' => 'profiled',
            'password' => bcrypt('password'),
        ]);
    }
}
