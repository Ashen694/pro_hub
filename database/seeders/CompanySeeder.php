<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Company::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $companies = [
            ['name' => 'Acme Corporation', 'type' => 'Customer', 'contact_email' => 'info@acme-corp.test', 'address' => '123 Acme Lane, Colombo'],
            ['name' => 'Globex Solutions Ltd', 'type' => 'Customer', 'contact_email' => 'contact@globex.test', 'address' => '456 Globe Plaza, Colombo'],
            ['name' => 'Initech Partners', 'type' => 'Partner', 'contact_email' => 'partnerships@initech.test', 'address' => '789 Innovation Drive, Kandy'],
            ['name' => 'Umbrella Technologies', 'type' => 'Customer', 'contact_email' => 'support@umbrella.test', 'address' => '1 Main Street, Galle'],
        ];

        foreach ($companies as $c) {
            Company::create($c);
        }
    }
}
