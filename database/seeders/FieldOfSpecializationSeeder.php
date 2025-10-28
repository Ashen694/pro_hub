<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FieldOfSpecialization;
use Illuminate\Support\Facades\DB;

class FieldOfSpecializationSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Backend Development', 'notes' => 'Server-side development: PHP, Java, Node.js'],
            ['name' => 'UX & UI Design', 'notes' => 'User experience, interaction design and prototyping'],
        ];

        foreach ($items as $itemData) {
            FieldOfSpecialization::firstOrCreate(
                ['name' => $itemData['name']], // Check by name
                $itemData // Create with this data if not found
            );
        }
    }
}
