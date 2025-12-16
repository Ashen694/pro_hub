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
            [
                'name' => 'Amal Silva', 
                'division' => 'Technology', 
                'email' => 'amal.silva@example.test', 
                'position' => 'Senior Engineer',
                'service_number' => 'EMP001',
                'contact_mobile' => '+94771234567',
                'group_name' => 'Development Team',
                'calling_name' => 'Amal',
                'gender' => 'Male',
                'section' => 'Software Development',
                'member_type' => 'divisional'
            ],
            [
                'name' => 'Bhasha Perera', 
                'division' => 'Operations', 
                'email' => 'bhasha.perera@example.test', 
                'position' => 'Operations Manager',
                'service_number' => 'EMP002',
                'contact_mobile' => '+94771234568',
                'group_name' => 'Operations Team',
                'calling_name' => 'Bhasha',
                'gender' => 'Female',
                'section' => 'Operations Management',
                'member_type' => 'divisional'
            ],
            [
                'name' => 'Chathura Fernando', 
                'division' => 'Technology', 
                'email' => 'chathura.fernando@example.test', 
                'position' => 'Viewer',
                'service_number' => 'VIEW001',
                'contact_mobile' => '+94771234569',
                'group_name' => 'External Users',
                'calling_name' => 'Chathura',
                'gender' => 'Male',
                'section' => 'External Access',
                'member_type' => 'view_only'
            ],
        ];

        foreach ($members as $memberData) {
            DivisionalMember::firstOrCreate(
                ['email' => $memberData['email']], // Check by email
                $memberData // Create with this data if not found
            );
        }
    }
}
