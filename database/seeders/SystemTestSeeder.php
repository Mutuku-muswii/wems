<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use App\Models\Vendor;
use App\Models\Event;
use Illuminate\Support\Facades\Hash;

class SystemTestSeeder extends Seeder
{
    public function run(): void
    {
        // 1. CREATE AN ADMIN (Store it in a variable to use for events)
        $admin = User::updateOrCreate(
            ['email' => 'admin@wems.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // 2. CREATE VENDORS
        $vendors = [
            ['name' => 'Safari Catering Ltd', 'category' => 'Catering', 'email' => 'safari@catering.com'],
            ['name' => 'Kili Sound & Lights', 'category' => 'Audio/Visual', 'email' => 'kili@sound.com'],
        ];

        foreach ($vendors as $v) {
            $vendorRecord = Vendor::create([
                'name' => $v['name'],
                'category' => $v['category'],
                'phone' => '0711223344',
            ]);

            User::create([
                'name' => $v['name'],
                'email' => $v['email'],
                'password' => Hash::make('password'),
                'role' => 'vendor',
                'vendor_id' => $vendorRecord->id,
            ]);
        }

        // 3. CREATE CLIENTS
        $clients = [
            ['name' => 'Gladys Mange', 'email' => 'gladys@example.com'],
            ['name' => 'Collins Muswii', 'email' => 'collins@example.com'],
        ];

        foreach ($clients as $c) {
            $clientRecord = Client::create([
                'name' => $c['name'],
                'email' => $c['email'],
                'phone' => '0722001122',
            ]);

            User::create([
                'name' => $c['name'],
                'email' => $c['email'],
                'password' => Hash::make('password'),
                'role' => 'client',
                'client_id' => $clientRecord->id,
            ]);

            // 4. CREATE EVENTS (Now including the required user_id)
            Event::create([
                'client_id' => $clientRecord->id,
                'user_id'   => $admin->id, // Fixed: This satisfies the database requirement
                'title'     => $c['name'] . "'s Strategy Launch",
                'location'  => 'Nairobi CBD',
                'event_date' => now()->addDays(14),
                'budget'    => 500000,
                'status'    => 'planning',
            ]);
        }
    }
}