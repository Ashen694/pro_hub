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
            'ParentProjectID' => $groups['CALL CENTRE SOLUTIONS'],
            'Developed_By' => 'Dinithi Weerasekera',
            'Developed_Team' => 'CRM Team',
            'SDLCPhase' => 'Maintenance',
            'Status' => 'Level 01',
            'StartDate' => '2020-08-01',
            'TargetDate' => '2020-09-30',
            'LaunchedDate' => '2025-10-06',
            'VADate' => '2020-10-15',
            'EndUserType' => 'SLT Employees',
            'Price' => 200000000.00
        ]);

        $mainApp2 = InternalPlatform::create([
            'App_Name' => 'HR Portal',
            'App_Category' => 'Main Application',
            'ParentProjectID' => $groups['ENTERPRISE PORTAL'],
            'Developed_By' => 'Nimal Perera',
            'Developed_Team' => 'Java Team',
            'SDLCPhase' => 'Maintenance',
            'Status' => 'Level 01',
            'StartDate' => '2023-05-10',
            'TargetDate' => '2023-07-10',
            'LaunchedDate' => '2025-07-15',
            'VADate' => '2023-07-20',
            'EndUserType' => 'SLT Employees',
            'Price' => 1500000.00
        ]);
        
        $mainApp3 = InternalPlatform::create([
            'App_Name' => 'Customer Feedback System',
            'App_Category' => 'Main Application',
            'ParentProjectID' => $groups['CUSTOMER EXPERIENCE'],
            'Developed_By' => 'Dayana Katawala',
            'Developed_Team' => 'PHP Team',
            'StartDate' => '2024-02-01',
            'TargetDate' => '2024-09-30',
            'SDLCPhase' => 'Design',
            'Status' => 'Level 01',
            'LaunchedDate' => null, // Not launched yet
            'VADate' => null,
            'EndUserType' => 'SLT Customers',
            'UserSpecificSection' => 'SLT' ,
            'Price' => 750000.00
        ]);

        $mainApp4 = InternalPlatform::create([
            'App_Name' => 'Old Legacy Billing',
            'App_Category' => 'Main Application',
            'ParentProjectID' => $groups['BILLING SUPPORT'],
            'Developed_By' => 'Sunil Shantha',
            'Developed_Team' => 'Infra Team',
            'SDLCPhase' => 'Retired',
            'Status' => 'Level 01', // Or can be null
            'StartDate' => '2015-01-01',
            'TargetDate' => '2015-05-30',
            'LaunchedDate' => '2015-06-15',
            'VADate' => '2015-06-10',
            'EndUserType' => 'Registered External Users',
            'Price' => 500000.00
        ]);

        $mainApp5 = InternalPlatform::create([
            'App_Name' => 'Product Info Hub',
            'App_Category' => 'Main Application',
            'ParentProjectID' => $groups['BILLING SUPPORT'],
            'Developed_By' => 'Sunil Shantha',
            'Developed_Team' => 'PHP Team',
            'SDLCPhase' => 'Abandoned',
            'Status' => 'Level 01',  
            'StartDate' => '2015-01-01',
            'TargetDate' => '2015-05-30',
            'LaunchedDate' => '2015-06-15',
            'VADate' => '2015-06-10',
            'EndUserType' => 'Registered External Users',
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
            'Status' => 'Level 01',
            'StartDate' => '2021-06-01',
            'TargetDate' => '2021-07-20',
            'LaunchedDate' => '2021-07-30',
            'VADate' => '2021-08-01',
            'EndUserType' => 'General Public',
            'Price' => 10000000.00
        ]);
        
        InternalPlatform::create([
            'App_Name' => 'PEARL Call Center - Loyalty CR',
            'App_Category' => 'Change Request',
            'ParentProjectID' => $mainApp1->ParentProjectID,
            'MainAppID' => $mainApp1->ID,
            'Developed_By' => 'Dinithi Weerasekera',
            'Developed_Team' => 'CRM Team',
            'SDLCPhase' => 'Design',
            'Status' => 'Level 02', // Changed for variety
            'StartDate' => '2022-01-15',
            'TargetDate' => '2022-02-28',
            'LaunchedDate' => '2022-03-05',
            'VADate' => '2022-03-01',
            'EndUserType' => 'General Public',
            'UserSpecificSection' => 'SLT' ,
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
            'Status' => 'Level 01',
            'LaunchedDate' => null, // Not launched yet
            'VADate' => null,
            'EndUserType' => 'SLT Employees',
            'UserSpecificSection' => 'LAB' ,
            'Price' => 250000.00
        ]);
    }
}