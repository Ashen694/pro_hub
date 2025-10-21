<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExternalSolution;

class ExternalSolutionSeeder extends Seeder
{
    public function run()
    {
        ExternalSolution::factory()->count(30)->create();
    }
}
