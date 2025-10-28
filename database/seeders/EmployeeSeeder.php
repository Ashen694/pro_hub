<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee; 
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

        $employees = [
            [
                'Emp_Name' => 'Dinithi Weerasekera',
                'Emp_Email' => 'dinithi.w@example.com',
                'Emp_Phone' => $faker->phoneNumber,
                'Section' => 'CRM Team',
                'Gender' => 'Female',
            ],
            [
                'Emp_Name' => 'Nimal Perera',
                'Emp_Email' => 'nimal.p@example.com',
                'Emp_Phone' => $faker->phoneNumber,
                'Section' => 'Java Team',
                'Gender' => 'Male',
            ],
            [
                'Emp_Name' => 'Dayana Katawala',
                'Emp_Email' => 'dayana.k@example.com',
                'Emp_Phone' => $faker->phoneNumber,
                'Section' => 'PHP Team',
                'Gender' => 'Female',
            ],
            [
                'Emp_Name' => 'Sunil Shantha',
                'Emp_Email' => 'sunil.s@example.com',
                'Emp_Phone' => $faker->phoneNumber,
                'Section' => 'Infra Team',
                'Gender' => 'Male',
            ],
            [
                'Emp_Name' => 'Ashen Kavindu',
                'Emp_Email' => 'ashen.k@example.com',
                'Emp_Phone' => $faker->phoneNumber,
                'Section' => 'Process Automation',
                'Gender' => 'Male',
            ],
            [
                'Emp_Name' => 'Anusha Kumari',
                'Emp_Email' => 'anusha.k@example.com',
                'Emp_Phone' => $faker->phoneNumber,
                'Section' => 'R&D',
                'Gender' => 'Female',
            ]
        ];

        foreach ($employees as $employeeData) {
            Employee::firstOrCreate(
                ['Emp_Email' => $employeeData['Emp_Email']], // Check by email
                $employeeData // Create with this data if not found
            );
        }
    }
}