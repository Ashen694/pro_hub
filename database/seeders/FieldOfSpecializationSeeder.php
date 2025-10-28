<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FieldOfSpecialization;
use Illuminate\Support\Facades\DB;

class FieldOfSpecializationSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        FieldOfSpecialization::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $items = [
            ['name' => 'Backend Development', 'notes' => 'Server-side development: PHP, Java, Node.js'],
            ['name' => 'UX & UI Design', 'notes' => 'User experience, interaction design and prototyping'],
        ];

        foreach ($items as $i) FieldOfSpecialization::create($i);
    }
}
