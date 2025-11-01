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
            ParentProjectSeeder::class,
            MainPlatformsSeeder::class,
            TargetEndUserSeeder::class,
            

            // Reference data seeders
            CompanySeeder::class,
            CustomerContactSeeder::class,
            DivisionalMemberSeeder::class,
            FieldOfSpecializationSeeder::class,

            InternalPlatformSeeder::class,

         
            SDLCphaseSeeder::class,
         
        ]);
    }
}
