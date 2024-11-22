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
            'email' => 'ictsupport@ictc.go.tz',
            'phone_number' => '11111111111',
            'rank' => 'internal',
            'password' => bcrypt('passpass'),
        ]);
        $admin->assignRole('admin');
    }
}
