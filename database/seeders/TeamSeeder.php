<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Demo team members linked to clients (the "others" demo data).
     * Uses updateOrCreate so it is idempotent.
     */
    public function run(): void
    {
        $apex = Client::where('name', 'Apex Dental Care')->first();
        $urban = Client::where('name', 'Urban Crust Pizza Co.')->first();
        $horizon = Client::where('name', 'Horizon Law Group')->first();
        $elevate = Client::where('name', 'Elevate Wellness & Spa')->first();

        $members = [
            [
                'name' => 'Sarah Jenkins',
                'email' => 'sarah@untab.com',
                'role' => 'Account Director',
                'assigned_clients' => isset($apex, $elevate) ? [$apex->id, $elevate->id] : [],
                'permissions' => ['posts' => true, 'reviews' => true, 'media' => true, 'reports' => true, 'settings' => true],
                'status' => 'Active',
            ],
            [
                'name' => 'Marcus Vance',
                'email' => 'marcus@untab.com',
                'role' => 'Local SEO Specialist',
                'assigned_clients' => isset($urban) ? [$urban->id] : [],
                'permissions' => ['posts' => true, 'reviews' => true, 'media' => true, 'reports' => true, 'settings' => false],
                'status' => 'Active',
            ],
            [
                'name' => 'Elena Rostova',
                'email' => 'elena@untab.com',
                'role' => 'Content & Review Manager',
                'assigned_clients' => isset($horizon) ? [$horizon->id] : [],
                'permissions' => ['posts' => true, 'reviews' => true, 'media' => true, 'reports' => false, 'settings' => false],
                'status' => 'Active',
            ],
            [
                'name' => 'Leo Bennett',
                'email' => 'leo@untab.com',
                'role' => 'Media Specialist',
                'assigned_clients' => isset($urban) ? [$urban->id] : [],
                'permissions' => ['posts' => true, 'reviews' => false, 'media' => true, 'reports' => false, 'settings' => false],
                'status' => 'Active',
            ],
            [
                'name' => 'Sophia Martinez',
                'email' => 'sophia@untab.com',
                'role' => 'Wellness Client Success',
                'assigned_clients' => isset($elevate) ? [$elevate->id] : [],
                'permissions' => ['posts' => true, 'reviews' => true, 'media' => true, 'reports' => true, 'settings' => false],
                'status' => 'Invited',
            ],
        ];

        foreach ($members as $member) {
            TeamMember::updateOrCreate(
                ['email' => $member['email']],
                [
                    'name' => $member['name'],
                    'role' => $member['role'],
                    'assigned_clients' => $member['assigned_clients'],
                    'permissions' => $member['permissions'],
                    'status' => $member['status'],
                ]
            );
        }
    }
}
