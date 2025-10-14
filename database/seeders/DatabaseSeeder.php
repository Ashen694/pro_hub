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
            // This must run first because InternalPlatformSeeder depends on it
            ParentProjectSeeder::class,
            
            // This runs second, using the data from the seeder above
            InternalPlatformSeeder::class,

            // Also keep your SDLC seeder
            SDLCphaseSeeder::class,
        ]);
    }
}
