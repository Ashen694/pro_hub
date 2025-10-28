<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MainPlatformsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('Main_Platforms')->insert([
            ['ID' => 1, 'Platforms' => 'Internal Solution'],
            ['ID' => 2, 'Platforms' => 'External Solution'],
        ]);
    }
}
