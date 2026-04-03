<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Create a client first
        $client = Client::create([
            'name' => 'Test Client Company',
            'email' => 'client@example.com',
            'phone' => '0700000001',
        ]);

        // Create a vendor first
        $vendor = Vendor::create([
            'name' => 'Test Vendor Services',
            'service_type' => 'Catering',
            'contact' => 'John Doe',
            'email' => 'vendor@example.com',
            'phone' => '0700000002',
        ]);

        // Admin
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@waridi.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Manager
        User::create([
            'name' => 'Event Manager',
            'email' => 'manager@waridi.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
        ]);

        // Staff
        User::create([
            'name' => 'Staff Member',
            'email' => 'staff@waridi.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        // Client (linked to client record)
        User::create([
            'name' => 'Client User',
            'email' => 'client@example.com',
            'password' => Hash::make('password'),
            'role' => 'client',
            'client_id' => $client->id,
        ]);

        // Vendor (linked to vendor record)
        User::create([
            'name' => 'Vendor User',
            'email' => 'vendor@example.com',
            'password' => Hash::make('password'),
            'role' => 'vendor',
            'vendor_id' => $vendor->id,
        ]);

        $this->command->info('Test users created:');
        $this->command->info('Admin: admin@waridi.com / password');
        $this->command->info('Manager: manager@waridi.com / password');
        $this->command->info('Staff: staff@waridi.com / password');
        $this->command->info('Client: client@example.com / password');
        $this->command->info('Vendor: vendor@example.com / password');
    }
}