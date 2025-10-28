<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DivisionalMember;
use Illuminate\Support\Facades\DB;

class DivisionalMemberSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DivisionalMember::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $members = [
            ['name' => 'Amal Silva', 'division' => 'Technology', 'email' => 'amal.silva@example.test', 'position' => 'Senior Engineer'],
            ['name' => 'Bhasha Perera', 'division' => 'Operations', 'email' => 'bhasha.perera@example.test', 'position' => 'Operations Manager'],
        ];

        foreach ($members as $m) DivisionalMember::create($m);
    }
}
