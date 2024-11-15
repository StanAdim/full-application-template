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


        $user = User::create([
            'first_name' => 'Startup',
            'middle_name' => 'User',
            'last_name' => 'Test',
            'email' => 'startup@example.com',
            'phone_number' => '11111111111',
            'rank' => 'profiled',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('user');
        $startupProfile = StartupProfile::create([
            'startup_name' => 'Test Startup',
            'industry' => 'Technology',
            'funding_stage' => 'Seed stage',
            'team_size' => 4,
            'founders' => [],
            'description' => 'A test startup description.',
        ]);
        $profile = new Profile([
            'user_id' => $user->id,
            'phone_number' => 'phone_number',
            'email' => 'email',
            'region' => 'region',
            'date_establishment' => 'date_establishment',
        ]);
        $profile->profileable()->associate($startupProfile);
        $profile->save();
    }
}
