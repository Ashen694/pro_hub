<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApplicationGroup;
use Illuminate\Support\Facades\DB;

class ApplicationGroupSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ApplicationGroup::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $groups = [
            ['name' => 'Billing Support', 'description' => 'Applications handling billing and invoicing'],
            ['name' => 'HR & Payroll', 'description' => 'Human Resources and payroll tools'],
        ];

        foreach ($groups as $g) ApplicationGroup::create($g);
    }
}
