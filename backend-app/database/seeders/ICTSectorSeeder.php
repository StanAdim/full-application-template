<?php

namespace Database\Seeders;

use App\Models\IctProduct;
use App\Models\ICTSector;
use Illuminate\Container\Attributes\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ICTSectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectors = [
            ['name' => 'Artificial Intelligence (AI)'],
            ['name' => 'Blockchain & Cryptocurrency'],
            ['name' => 'EdTech (Education Technology)'],
            ['name' => 'FinTech (Financial Technology)'],
            ['name' => 'HealthTech (Healthcare Technology)'],
            ['name' => 'E-commerce & Retail'],
            ['name' => 'Renewable Energy & CleanTech'],
            ['name' => 'AgriTech (Agriculture Technology)'],
            ['name' => 'SpaceTech'],
            ['name' => 'Gaming & Entertainment'],
            ['name' => 'Internet of Things (IoT)'],
            ['name' => 'Cybersecurity'],
            ['name' => 'PropTech (Property Technology)'],
            ['name' => 'TravelTech'],
            ['name' => 'FoodTech'],
            ['name' => 'FashionTech'],
            ['name' => 'Media & Content Creation'],
            ['name' => 'Social Media & Networking'],
            ['name' => 'SportsTech'],
            ['name' => 'Water & Waste Management'],
            ['name' => 'Circular Economy'],
            ['name' => 'Sustainable Transportation'],
            ['name' => 'Logistics & Supply Chain'],
            ['name' => 'Advanced Manufacturing'],
            ['name' => 'Aerospace & Defense'],
            ['name' => 'Automotive Technology'],
            ['name' => 'ConstructionTech (including Smart Cities)'],
            ['name' => 'Biotech & Life Sciences'],
            ['name' => 'Material Science'],
            ['name' => 'Environmental Science'],
            ['name' => 'Nonprofit & CivicTech'],
            ['name' => 'Diversity & Inclusion'],
            ['name' => 'Public Services (e.g., GovTech)'],
            ['name' => 'Web3 & Metaverse'],
            ['name' => 'Quantum Computing'],
            ['name' => 'Virtual Reality (VR) & Augmented Reality (AR)'],
            ['name' => 'Wellness & Mental Health'],
            ['name' => 'Robotics & Automation'],
            ['name' => 'Software as a Service (SaaS)'],
            ['name' => 'Cloud Computing']
        ];
        

       foreach ($sectors as $sector){
            ICTSector::create($sector);
       }
    }
}
