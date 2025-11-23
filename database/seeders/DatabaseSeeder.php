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
            UserSeeder::class,
            EmployeeSeeder::class,
            ParentProjectSeeder::class,
            MainPlatformsSeeder::class,
            TargetEndUserSeeder::class,
            SDLCphaseSeeder::class,
            

            // Reference data seeders
            CompanySeeder::class,
            CustomerContactSeeder::class,
            DivisionalMemberSeeder::class,
            FieldOfSpecializationSeeder::class,

            InternalPlatformSeeder::class,
            ExternalPlatformSeeder::class,

            // Trainee seeder
            TraineeSeeder::class,

         
            
         
        ]);
    }
}
