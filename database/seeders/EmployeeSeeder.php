<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee; // Employee model ಅನ್ನು ಇಂಪೋರ್ಟ್ ಮಾಡಿ
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $faker = Faker::create();

        Employee::create([
            'Emp_Name' => 'Dinithi Weerasekera',
            'Emp_Email' => 'dinithi.w@example.com',
            'Emp_Phone' => $faker->phoneNumber,
            'Section' => 'CRM Team',
            'Gender' => 'Female',
        ]);
        Employee::create([
            'Emp_Name' => 'Nimal Perera',
            'Emp_Email' => 'nimal.p@example.com',
            'Emp_Phone' => $faker->phoneNumber,
            'Section' => 'Java Team',
            'Gender' => 'Male',
        ]);
        Employee::create([
            'Emp_Name' => 'Dayana Katawala',
            'Emp_Email' => 'dayana.k@example.com',
            'Emp_Phone' => $faker->phoneNumber,
            'Section' => 'PHP Team',
            'Gender' => 'Female',
        ]);
        Employee::create([
            'Emp_Name' => 'Sunil Shantha',
            'Emp_Email' => 'sunil.s@example.com',
            'Emp_Phone' => $faker->phoneNumber,
            'Section' => 'Infra Team',
            'Gender' => 'Male',
        ]);
        Employee::create([
            'Emp_Name' => 'Ashen Kavindu',
            'Emp_Email' => 'ashen.k@example.com',
            'Emp_Phone' => $faker->phoneNumber,
            'Section' => 'Process Automation',
            'Gender' => 'Male',
        ]);
        Employee::create([
            'Emp_Name' => 'Anusha Kumari',
            'Emp_Email' => 'anusha.k@example.com',
            'Emp_Phone' => $faker->phoneNumber,
            'Section' => 'R&D',
            'Gender' => 'Female',
        ]);

         
    }
}