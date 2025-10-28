<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MainPlatformsSeeder extends Seeder
{
    public function run(): void
    {
        $platforms = [
            ['ID' => 1, 'Platforms' => 'Internal Solution'],
            ['ID' => 2, 'Platforms' => 'External Solution'],
        ];

        foreach ($platforms as $platform) {
            DB::table('Main_Platforms')->updateOrInsert(
                ['ID' => $platform['ID']], // Check by ID
                $platform // Update or insert with this data
            );
        }
    }
}
