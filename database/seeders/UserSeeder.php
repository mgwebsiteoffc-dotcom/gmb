<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Demo accounts for every role:
     *  - Super Admin (SaaS owner)
     *  - Brand Admins (scoped to a client)
     *  - Standard users / staff
     */
    public function run(): void
    {
        $password = 'password123';

        // --- 1. Super Admin / SaaS Owner ---
        User::updateOrCreate(
            ['email' => 'owner@untab.com'],
            [
                'name' => 'Untab Owner',
                'password' => Hash::make($password),
                'role' => User::ROLE_SUPER_ADMIN,
                'client_id' => null,
                'is_active' => true,
                'plan' => 'pro',
                'email_verified_at' => now(),
            ]
        );

        // A second super admin for team scenarios.
        User::updateOrCreate(
            ['email' => 'admin@untab.com'],
            [
                'name' => 'Alex Super Admin',
                'password' => Hash::make($password),
                'role' => User::ROLE_SUPER_ADMIN,
                'client_id' => null,
                'is_active' => true,
                'plan' => 'pro',
                'email_verified_at' => now(),
            ]
        );

        // --- 2. Brand Admins (tied to specific clients) ---
        $brandAdminAccounts = [
            ['email' => 'apex@untab.com', 'name' => 'Apex Brand Admin', 'client_match' => 'Apex Dental Care'],
            ['email' => 'urban@untab.com', 'name' => 'Urban Crust Brand Admin', 'client_match' => 'Urban Crust Pizza Co.'],
            ['email' => 'horizon@untab.com', 'name' => 'Horizon Brand Admin', 'client_match' => 'Horizon Law Group'],
            ['email' => 'elevate@untab.com', 'name' => 'Elevate Brand Admin', 'client_match' => 'Elevate Wellness & Spa'],
        ];

        foreach ($brandAdminAccounts as $account) {
            $client = Client::where('name', $account['client_match'])->first();

            User::updateOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'password' => Hash::make($password),
                    'role' => User::ROLE_BRAND_ADMIN,
                    'client_id' => $client?->id,
                    'is_active' => true,
                    'plan' => 'agency',
                    'email_verified_at' => now(),
                ]
            );
        }

        // --- 3. Standard users / staff (agency operators) ---
        $staffAccounts = [
            ['email' => 'sarah@untab.com', 'name' => 'Sarah Jenkins', 'role' => 'Account Director'],
            ['email' => 'marcus@untab.com', 'name' => 'Marcus Vance', 'role' => 'Local SEO Specialist'],
            ['email' => 'elena@untab.com', 'name' => 'Elena Rostova', 'role' => 'Content & Review Manager'],
            ['email' => 'leo@untab.com', 'name' => 'Leo Bennett', 'role' => 'Media Specialist'],
        ];

        foreach ($staffAccounts as $account) {
            User::updateOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'password' => Hash::make($password),
                    'role' => User::ROLE_USER,
                    'client_id' => null,
                    'is_active' => true,
                    'plan' => 'free',
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
