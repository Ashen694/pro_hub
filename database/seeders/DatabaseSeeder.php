<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            EmployeeSeeder::class,
            // This must run first because InternalPlatformSeeder depends on it
            ParentProjectSeeder::class,
            
            // This runs second, using the data from the seeder above
            InternalPlatformSeeder::class,

            // Reference data seeders
            CompanySeeder::class,
            CustomerContactSeeder::class,
            DivisionalMemberSeeder::class,
            ApplicationGroupSeeder::class,
            FieldOfSpecializationSeeder::class,

         
            SDLCphaseSeeder::class,
            TargetEndUserSeeder::class,
        ]);
    }
}
