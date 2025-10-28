<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DivisionalMember;
use Illuminate\Support\Facades\DB;

class DivisionalMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            ['name' => 'Amal Silva', 'division' => 'Technology', 'email' => 'amal.silva@example.test', 'position' => 'Senior Engineer'],
            ['name' => 'Bhasha Perera', 'division' => 'Operations', 'email' => 'bhasha.perera@example.test', 'position' => 'Operations Manager'],
        ];

        foreach ($members as $memberData) {
            DivisionalMember::firstOrCreate(
                ['email' => $memberData['email']], // Check by email
                $memberData // Create with this data if not found
            );
        }
    }
}
