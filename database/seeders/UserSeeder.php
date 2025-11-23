<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;  
use Illuminate\Support\Facades\Hash;  

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Administrator User
        User::firstOrCreate(
            ['email' => 'admin@prohub.lk'], 
            [
                'name' => 'Ashen',
                'password' => Hash::make('prohub123'), 
                'role' => 'Administrator',
                'is_active' => true,
            ]
        );

        // Developer User
        User::firstOrCreate(
            ['email' => 'dev1@prohub.lk'],
            [
                'name' => 'Developer One',
                'password' => Hash::make('dev@12345'),
                'role' => 'Developer',
                'is_active' => true,
            ]
        );

        // View Only User
        User::firstOrCreate(
            ['email' => 'viewer@prohub.lk'],
            [
                'name' => 'Menusha',
                'password' => Hash::make('viewer@123'),
                'role' => 'View_only_user',
                'is_active' => true,
            ]
        );
        
        // Inactive User  
        User::firstOrCreate(
            ['email' => 'inactive@prohub.lk'],
            [
                'name' => 'Kavindu',
                'password' => Hash::make('inactive@123'),
                'role' => 'Inactive_User',
                'is_active' => false,  
            ]
        );

        // ishamp_user
        User::firstOrCreate(
            ['email' => 'ishamp@prohub.lk'],
            [
                'name' => 'Sanuda',
                'password' => Hash::make('ishamp@123'),
                'role' => 'Ishamp_user',
                'is_active' => true,  
            ]
        );

        // dpo_user  
        User::firstOrCreate(
            ['email' => 'dpo@prohub.lk'],
            [
                'name' => 'Ranuki',
                'password' => Hash::make('dpo@123'),
                'role' => 'Dpo_user',
                'is_active' => true,  
            ]
        );
    }
}