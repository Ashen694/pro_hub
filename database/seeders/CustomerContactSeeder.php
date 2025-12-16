<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CustomerContact;
use App\Models\Company;
use App\Models\ExternalPlatform;
use Illuminate\Support\Facades\DB;

class CustomerContactSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();
        $externalPlatforms = ExternalPlatform::all();
        
        if ($companies->isEmpty()) return;

        // Add one contact per company with clear details
        foreach ($companies as $index => $company) {
            // Assign external platforms in a round-robin fashion
            $platformId = $externalPlatforms->isNotEmpty() ? $externalPlatforms[$index % $externalPlatforms->count()]->platform_id : null;
            
            $contactData = [
                'company_id' => $company->id,
                'external_platform_id' => $platformId,
                'title' => ['Mr', 'Mrs', 'Ms', 'Dr'][$index % 4],
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
