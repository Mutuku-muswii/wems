<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use App\Models\Vendor;
use App\Models\Event;
use App\Models\Service;
use App\Models\Attendee;
use Illuminate\Support\Facades\Hash;

class MasterSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating Waridi Events Master Data for Defense...');

        // 1. INTERNAL USERS
        $admin = User::create([
            'name' => 'System Administrator',
            'email' => 'admin@waridi.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $manager = User::create([
            'name' => 'Event Manager',
            'email' => 'manager@waridi.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
        ]);

        $staff = User::create([
            'name' => 'Staff Member',
            'email' => 'staff@waridi.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        // 2. CLIENTS & CLIENT USERS
        $clientsData = [
            ['name' => 'Safaricom PLC', 'email' => 'events@safaricom.co.ke', 'phone' => '0722000000'],
            ['name' => 'Johnson Wedding', 'email' => 'johnson@email.com', 'phone' => '0712345678'],
            ['name' => 'KCA University', 'email' => 'events@kca.ac.ke', 'phone' => '0733445566'],
        ];

        $createdClients = [];
        foreach ($clientsData as $data) {
            $client = Client::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone']
            ]);

            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'client',
                'client_id' => $client->id,
            ]);
            $createdClients[] = $client;
        }

        // 3. VENDORS & VENDOR USERS
        $vendorsData = [
            ['name' => 'Waridi Catering', 'service_type' => 'Catering', 'email' => 'catering@waridi.com'],
            ['name' => 'Sound Masters', 'service_type' => 'Sound', 'email' => 'sound@masters.com'],
            ['name' => 'Floral Designs', 'service_type' => 'Decoration', 'email' => 'flowers@floral.com'],
        ];

        $createdVendors = [];
        foreach ($vendorsData as $vData) {
            $vendor = Vendor::create([
                'name' => $vData['name'],
                'category' => $vData['service_type'], // Matches your 'category' column
                'email' => $vData['email'],
            ]);

            User::create([
                'name' => $vData['name'],
                'email' => $vData['email'],
                'password' => Hash::make('password'),
                'role' => 'vendor',
                'vendor_id' => $vendor->id,
            ]);
            $createdVendors[] = $vendor;
        }

        // 4. EVENTS
        $event1 = Event::create([
            'title' => 'Safaricom 25th Anniversary Gala',
            'client_id' => $createdClients[0]->id,
            'event_date' => '2026-05-15',
            'location' => 'KICC Nairobi',
            'budget' => 1500000,
            'status' => 'confirmed',
            'user_id' => $manager->id,
        ]);

        $event2 = Event::create([
            'title' => 'Johnson Wedding Reception',
            'client_id' => $createdClients[1]->id,
            'event_date' => '2026-06-20',
            'location' => 'Karen Country Club',
            'budget' => 450000,
            'status' => 'planning',
            'user_id' => $staff->id,
        ]);

        // 5. SERVICES (Linked to actual Event and Vendor IDs)
        Service::create([
            'event_id' => $event1->id,
            'vendor_id' => $createdVendors[0]->id,
            'name' => 'Full Catering Package',
            'cost' => 600000
        ]);

        Service::create([
            'event_id' => $event2->id,
            'vendor_id' => $createdVendors[2]->id,
            'name' => 'Wedding Decor',
            'cost' => 150000
        ]);

        // 6. ATTENDEES
        // Note: Only including common columns to avoid errors if 'rsvp' is missing
        Attendee::create([
            'event_id' => $event2->id,
            'name' => 'Mr. James Johnson',
            'email' => 'james@email.com',
            'phone' => '0711111111',
        ]);

        Attendee::create([
            'event_id' => $event1->id,
            'name' => 'CEO Safaricom',
            'email' => 'ceo@safaricom.co.ke',
            'phone' => '0755555555',
        ]);

        $this->command->info('✅ Master Data Created Successfully!');
    }
}