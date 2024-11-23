<?php

namespace Database\Seeders;

use App\Models\FundingStage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FundingStageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stages = [
            [
                'name' => 'Pre-Seed',
                'description' => 'Early funding from founders, friends, or angel investors to develop an idea or MVP.'
            ],
            [
                'name' => 'Seed',
                'description' => 'First official funding round to build the team, product, and acquire initial customers.'
            ],
            [
                'name' => 'Series A',
                'description' => 'Funding to scale operations, refine the product, and optimize the business model.'
            ],
            [
                'name' => 'Series B',
                'description' => 'Growth-focused funding to expand market reach and enhance infrastructure.'
            ],
            [
                'name' => 'Series C',
                'description' => 'Funding for mature startups to expand globally, launch new products, or prepare for IPO.'
            ],
            [
                'name' => 'Mezzanine / Bridge',
                'description' => 'Funding to position the company for a major event like an IPO or acquisition.'
            ],
            [
                'name' => 'IPO',
                'description' => 'Company offers shares to the public to raise significant capital.'
            ],
            [
                'name' => 'Bootstrapping',
                'description' => 'Self-funded growth with no external investors, common in niche startups.'
            ]
        ];
        foreach ($stages as $item){
            FundingStage::create($item);
       }
    }
}
