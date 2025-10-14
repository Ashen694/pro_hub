<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParentProject;
use Illuminate\Support\Facades\DB;

class ParentProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate the table before seeding to avoid duplicates on re-run
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ParentProject::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $groups = [
            ['ParentProjectGroup' => 'BILLING SUPPORT', 'OperationScope' => 'Finance'],
            ['ParentProjectGroup' => 'CUSTOMER EXPERIENCE', 'OperationScope' => 'Marketing'],
            ['ParentProjectGroup' => 'ENTERPRISE PORTAL', 'OperationScope' => 'HR & Internal'],
            ['ParentProjectGroup' => 'PROCESS AUTOMATION', 'OperationScope' => 'Operations'],
            ['ParentProjectGroup' => 'CALL CENTRE SOLUTIONS', 'OperationScope' => 'Customer Care'],
            ['ParentProjectGroup' => 'R&D', 'OperationScope' => 'Technology'],
        ];

        foreach ($groups as $group) {
            ParentProject::create($group);
        }
    }
}