<?php

namespace Database\Seeders;

use App\Models\Categories\Profile;
use App\Models\Categories\StartupProfile;
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
        $admin = User::create([
            'first_name' => 'Admin',
            'middle_name' => 'ICT',
            'last_name' => 'Commission',
            'email' => env('DEFAULT_USER_EMAIL', 'default@mail.com'),
            'phone_number' => '+255736848444',
            'rank' => env('DEFAULT_USER_RANK', 'default'),
            'password' => bcrypt(env('DEFAULT_USER_PASSWORD', 'default')),
        ]);
        $admin->assignRole('admin');
    }
}
