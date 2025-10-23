<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TargetEndUser; // Import the model
use Illuminate\Support\Facades\DB; // Import DB facade for truncating

class TargetEndUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Optional: Clear the table before seeding to avoid duplicates
        DB::table('TargetEndUser')->truncate();

        // Define the data to be inserted
        $userTypes = [
            'SLT Employees',
            'SLT Customers',
            'General Public',
            'Registered External Users',
        ];

        // Loop through the data and create records
        foreach ($userTypes as $type) {
            TargetEndUser::create(['EndUserType' => $type]);
        }
    }
}