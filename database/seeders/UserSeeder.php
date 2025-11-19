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
                'role' => 'developer',
                'is_active' => true,
            ]
        );

        // View Only User
        User::firstOrCreate(
            ['email' => 'viewer@prohub.lk'],
            [
                'name' => 'Guest Viewer',
                'password' => Hash::make('viewer@123'),
                'role' => 'view_only_user',
                'is_active' => true,
            ]
        );
        
        // Inactive User  
        User::firstOrCreate(
            ['email' => 'inactive@prohub.lk'],
            [
                'name' => 'Inactive User',
                'password' => Hash::make('inactive@123'),
                'role' => 'developer',
                'is_active' => false,  
            ]
        );

        // ishamp_user
        User::firstOrCreate(
            ['email' => 'ishamp@prohub.lk'],
            [
                'name' => 'Inactive User',
                'password' => Hash::make('ishamp@123'),
                'role' => 'ishamp_user',
                'is_active' => true,  
            ]
        );

        // dpo_user  
        User::firstOrCreate(
            ['email' => 'dpo@prohub.lk'],
            [
                'name' => 'Inactive User',
                'password' => Hash::make('dpo@123'),
                'role' => 'dpo_user',
                'is_active' => true,  
            ]
        );
    }
}