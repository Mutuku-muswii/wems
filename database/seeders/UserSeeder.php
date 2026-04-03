<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::firstOrCreate(
            ['email' => 'admin@waridi.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '0700000000',
            ]
        );

        // Manager
        User::firstOrCreate(
            ['email' => 'manager@waridi.com'],
            [
                'name' => 'Event Manager',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'phone' => '0700000001',
            ]
        );

        // Staff
        User::firstOrCreate(
            ['email' => 'staff@waridi.com'],
            [
                'name' => 'Staff Member',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'phone' => '0700000002',
            ]
        );

        // Client - create client first, then user
        $client = Client::firstOrCreate(
            ['email' => 'client@example.com'],
            [
                'name' => 'Test Client',
                'phone' => '0700000003',
            ]
        );

        User::firstOrCreate(
            ['email' => 'client@example.com'],
            [
                'name' => 'Test Client',
                'password' => Hash::make('password'),
                'role' => 'client',
                'client_id' => $client->id,
                'phone' => '0700000003',
            ]
        );

        // Vendor - create vendor first, then user
        $vendor = Vendor::firstOrCreate(
            ['email' => 'vendor@waridicatering.com'],
            [
                'name' => 'Waridi Catering',
                'service_type' => 'Catering',
                'contact' => 'Contact Person',
                'phone' => '0700000004',
            ]
        );

        User::firstOrCreate(
            ['email' => 'vendor@waridicatering.com'],
            [
                'name' => 'Waridi Catering',
                'password' => Hash::make('password'),
                'role' => 'vendor',
                'vendor_id' => $vendor->id,
                'phone' => '0700000004',
            ]
        );

        $this->command->info('Test users verified/created:');
        $this->command->info('Admin: admin@waridi.com / password');
        $this->command->info('Manager: manager@waridi.com / password');
        $this->command->info('Staff: staff@waridi.com / password');
        $this->command->info('Client: client@example.com / password');
        $this->command->info('Vendor: vendor@waridicatering.com / password');
    }
}