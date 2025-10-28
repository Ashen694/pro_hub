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
        $groups = [
            ['ParentProjectGroup' => 'BILLING SUPPORT', 'OperationScope' => 'Finance'],
            ['ParentProjectGroup' => 'CUSTOMER EXPERIENCE', 'OperationScope' => 'Marketing'],
            ['ParentProjectGroup' => 'ENTERPRISE PORTAL', 'OperationScope' => 'HR & Internal'],
            ['ParentProjectGroup' => 'PROCESS AUTOMATION', 'OperationScope' => 'Operations'],
            ['ParentProjectGroup' => 'CALL CENTRE SOLUTIONS', 'OperationScope' => 'Customer Care'],
            ['ParentProjectGroup' => 'R&D', 'OperationScope' => 'Technology'],
        ];

        foreach ($groups as $group) {
            ParentProject::firstOrCreate(
                ['ParentProjectGroup' => $group['ParentProjectGroup']], // Check by group name
                $group // Create with this data if not found
            );
        }
    }
}