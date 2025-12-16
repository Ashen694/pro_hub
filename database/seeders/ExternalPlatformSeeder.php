<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExternalPlatform;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;  

class ExternalPlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Create sample external platforms

        $platforms = [
            [
                'platform_name' => 'Customer Portal',
                'platform_type' => 'Web Application',
                'status' => 'operational',
                'sdlc_stage' => 'Maintenance',
                'percentage_done' => 100,
            ],
            [
                'platform_name' => 'Mobile Banking App',
                'platform_type' => 'Mobile Application',
                'status' => 'operational',
                'sdlc_stage' => 'Maintenance',
                'percentage_done' => 100,
            ],
            [
                'platform_name' => 'E-commerce Platform',
                'platform_type' => 'Web Application',
                'status' => 'prospective',
                'sdlc_stage' => 'Development',
                'percentage_done' => 75,
            ],
            [
                'platform_name' => 'CRM Integration',
                'platform_type' => 'API Integration',
                'status' => 'operational',
                'sdlc_stage' => 'Maintenance',
                'percentage_done' => 100,
            ],
            [
                'platform_name' => 'Analytics Dashboard',
                'platform_type' => 'Dashboard',
                'status' => 'prospective',
                'sdlc_stage' => 'Testing',
                'percentage_done' => 90,
            ]
        ];

        foreach ($platforms as $platformData) {
            ExternalPlatform::firstOrCreate(
                ['platform_name' => $platformData['platform_name']],
                $platformData
            );
        }
    }
}