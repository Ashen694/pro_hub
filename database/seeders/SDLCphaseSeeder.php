<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SDLCphase;  

class SDLCphaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         SDLCphase::truncate();

        $phases = [
            ['Phase' => 'Proposal Preparation', 'OrderSeq' => 10],
            ['Phase' => 'Proposal Submitted', 'OrderSeq' => 20],
            ['Phase' => 'Requirement Gathering and Analysis', 'OrderSeq' => 30],
            ['Phase' => 'Design', 'OrderSeq' => 40],
            ['Phase' => 'Coding or Implementation', 'OrderSeq' => 50],
            ['Phase' => 'Testing', 'OrderSeq' => 60],
            ['Phase' => 'Deployment', 'OrderSeq' => 70],
            ['Phase' => 'Maintenance', 'OrderSeq' => 80],
            ['Phase' => 'Retired', 'OrderSeq' => 90],
            ['Phase' => 'Abandoned', 'OrderSeq' => 100],
        ];

        foreach ($phases as $phase) {
            SDLCphase::create($phase);
        }
    }
}