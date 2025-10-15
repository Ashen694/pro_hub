<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InternalPlatform;
use App\Models\ParentProject;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class InternalPlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate the table before seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        InternalPlatform::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Faker::create();

        // Get groups as a collection of ['GroupName' => ID]
        $groups = ParentProject::pluck('ParentProjectID', 'ParentProjectGroup');

        // --- Create Main Applications ---
        $mainApp1 = InternalPlatform::create([
            'App_Name' => 'PEARL Call Center',
            'App_Category' => 'Main Application',
            'ParentProjectID' => $groups['CALL CENTRE SOLUTIONS'], // Correct way to get ID
            'Developed_By' => 'Dinithi Weerasekera',
            'Developed_Team' => 'CRM Team',
            'SDLCPhase' => 'Maintenance',
            'VADate' => '2020-10-15',
            'Price' => 200000000.00
        ]);

        $mainApp2 = InternalPlatform::create([
            'App_Name' => 'HR Portal',
            'App_Category' => 'Main Application',
            'ParentProjectID' => $groups['ENTERPRISE PORTAL'], // Correct way to get ID
            'Developed_By' => 'Nimal Perera',
            'Developed_Team' => 'Java Team',
            'SDLCPhase' => 'Maintenance',
            'VADate' => '2023-07-20',
            'Price' => 1500000.00
        ]);
        
        $mainApp3 = InternalPlatform::create([
            'App_Name' => 'Customer Feedback System',
            'App_Category' => 'Main Application',
            'ParentProjectID' => $groups['CUSTOMER EXPERIENCE'], // Correct way to get ID
            'Developed_By' => 'Dayana Katawala',
            'Developed_Team' => 'PHP Team',
            'StartDate' => '2024-02-01',
            'TargetDate' => '2024-09-30',
            'SDLCPhase' => 'Design',
            'Price' => 750000.00
        ]);

        $mainApp4 = InternalPlatform::create([
            'App_Name' => 'Old Legacy Billing',
            'App_Category' => 'Main Application',
            'ParentProjectID' => $groups['BILLING SUPPORT'], // Correct way to get ID
            'Developed_By' => 'Sunil Shantha',
            'Developed_Team' => 'Infra Team',
            'SDLCPhase' => 'Retired',
            'LaunchedDate' => '2015-06-15',
            'Price' => 500000.00
        ]);


        // --- Create Change Requests and link them to Main Applications ---
        InternalPlatform::create([
            'App_Name' => 'PEARL Call Center - CR 2021',
            'App_Category' => 'Change Request',
            'ParentProjectID' => $mainApp1->ParentProjectID,
            'MainAppID' => $mainApp1->ID,
            'Developed_By' => 'Dinithi Weerasekera',
            'Developed_Team' => 'CRM Team',
            'SDLCPhase' => 'Maintenance',
            'VADate' => '2021-08-01',
            'Price' => 10000000.00
        ]);
        
        InternalPlatform::create([
            'App_Name' => 'PEARL Call Center - Loyalty CR',
            'App_Category' => 'Change Request',
            'ParentProjectID' => $mainApp1->ParentProjectID,
            'MainAppID' => $mainApp1->ID,
            'Developed_By' => 'Dinithi Weerasekera',
            'Developed_Team' => 'CRM Team',
            'SDLCPhase' => 'Maintenance',
            'Price' => 1000000.00
        ]);
        
        InternalPlatform::create([
            'App_Name' => 'HR Portal - Leave Module Update',
            'App_Category' => 'Change Request',
            'ParentProjectID' => $mainApp2->ParentProjectID,
            'MainAppID' => $mainApp2->ID,
            'Developed_By' => 'Nimal Perera',
            'Developed_Team' => 'Java Team',
            'StartDate' => '2024-03-10',
            'TargetDate' => '2024-05-20',
            'SDLCPhase' => 'Testing',
            'Price' => 250000.00
        ]);
    }
}