<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CustomerContact;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CustomerContactSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();
        if ($companies->isEmpty()) return;

        // Add one contact per company with clear details
        foreach ($companies as $company) {
            $contactData = [
                'company_id' => $company->id,
                'name' => $company->name . ' - Primary Contact',
                'email' => 'contact+' . strtolower(str_replace(' ', '.', $company->name)) . '@example.test',
                'phone' => '+94 77 ' . rand(1000000, 9999999),
                'role' => 'Account Manager',
            ];

            CustomerContact::firstOrCreate(
                ['email' => $contactData['email']], // Check by email
                $contactData // Create with this data if not found
            );
        }
    }
}
