<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExternalPlatform;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;  

class ExternalPlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
 
        ExternalPlatform::truncate();

        for ($i = 0; $i < 10; $i++) {  
            ExternalPlatform::create([
                'platform_name' => $faker->company . ' Platform',
                'platform_type' => $faker->randomElement(['CRM', 'ERP', 'Project Management', 'E-commerce', 'Marketing Automation']),
                'start_date' => $faker->date(),
                'target_date' => $faker->date(),
                'developed_by' => $faker->company,
                'developed_team' => $faker->words(2, true) . ' Team',
                'bitbucket' => $faker->url,
                'bit_bucket_repo' => $faker->slug(),
                'sdlc_stage' => $faker->randomElement(['Design', 'Development', 'Testing', 'Deployment', 'Maintenance']),
                'percentage_done' => $faker->numberBetween(10, 100),
                'status' => $faker->randomElement(['Active', 'Inactive', 'Pending', 'Archived']),
                'status_date' => $faker->date(),
                'integrated_apps' => $faker->words(3, true),
                'dr' => $faker->word,
                'company_id' => $faker->numberBetween(1, 5),
                'sales_team_id' => $faker->numberBetween(1, 3),
                'sales_am' => $faker->name,
                'sales_manager' => $faker->name,
                'sales_engineer' => $faker->name,
                'uat_date' => $faker->date(),
                'va_date' => $faker->date(),
                'launched_date' => $faker->date(),
                'platform_owner' => $faker->name,
                'app_op_owner' => $faker->name,
                'platform_otc' => $faker->randomFloat(2, 100, 10000),
                'platform_mrc' => $faker->randomFloat(2, 50, 5000),
                'contract_period' => $faker->randomElement(['1 Year', '2 Years', '3 Years', 'Monthly']),
                'incentive_earned' => $faker->randomFloat(2, 0, 1000),
                'incentive_share' => $faker->randomFloat(2, 0, 500),
                'billing_date' => $faker->date(),
                'proposal_upload' => $faker->url,
                'sla' => $faker->sentence(3),
                'software_value' => $faker->randomFloat(2, 1000, 100000),
                'backup_officer_1' => $faker->name,
                'backup_officer_2' => $faker->name,
                'ssl_certificate_exp_date' => $faker->dateTimeBetween('now', '+2 years')->format('Y-m-d'),
                'dpo_handover' => $faker->name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}