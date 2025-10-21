<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ExternalSolution;

class ExternalSolutionFactory extends Factory
{
    protected $model = ExternalSolution::class;

    public function definition()
    {
        return [
            'application_name' => $this->faker->company . ' App',
            'company_customer' => $this->faker->company,
            'developed_by' => $this->faker->companySuffix,
            'developed_team' => $this->faker->word,
            'start_date' => $this->faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d'),
            'target_date' => $this->faker->dateTimeBetween('now', '+1 years')->format('Y-m-d'),
            'dplo_stage' => $this->faker->randomElement(['Proposal/Preparation','Requirement Gathering','Development']),
            'sdlc_stage' => $this->faker->randomElement(['Proposal/Preparation','Requirement Gathering','Development']),
            'percentage_done' => (string)$this->faker->numberBetween(0,100),
            'bitbucket_repository_name' => $this->faker->word,
            'sales_team_involved' => $this->faker->randomElement(['Government Business','Enterprise Business','Carrier Business','Region Business']),
            'sales_account_manager' => $this->faker->name,
            'sales_manager' => $this->faker->name,
            'sales_engineer' => $this->faker->name,
            'uat_date' => $this->faker->dateTimeBetween('now','+6 months')->format('Y-m-d'),
            'launched_date' => optional($this->faker->optional(0.6)->dateTimeBetween('-6 months','now'))->format('Y-m-d'),
            'one_time_charge' => $this->faker->randomFloat(2,1000,100000),
            'monthly_recurring_charge' => $this->faker->randomFloat(2,100,10000),
            'value_of_software' => $this->faker->randomFloat(2,1000,1000000),
            'contract_period_years' => $this->faker->numberBetween(1,5),
            'support_availability' => $this->faker->randomElement(['24x7','24x5','8x5']),
            'dpo_handover_date' => optional($this->faker->optional()->dateTimeBetween('now','+1 years'))->format('Y-m-d'),
            'dpo_handover_comments' => $this->faker->optional()->sentence,
        ];
    }
}
