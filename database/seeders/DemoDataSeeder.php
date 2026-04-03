<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Event;
use App\Models\Vendor;
use App\Models\Service;
use App\Models\Attendee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create Clients
        $client1 = Client::create([
            'name' => 'Johnson Wedding Party',
            'email' => 'johnson.family@email.com',
            'phone' => '0722123456',
        ]);

        $client2 = Client::create([
            'name' => 'Safaricom PLC',
            'email' => 'events@safaricom.co.ke',
            'phone' => '0722123457',
        ]);

        $client3 = Client::create([
            'name' => 'Nairobi Chapel',
            'email' => 'admin@nairobichapel.org',
            'phone' => '0722123458',
        ]);

        $this->command->info('3 clients created');

        // Create Vendors
        $vendor1 = Vendor::create([
            'name' => 'Waridi Catering Services',
            'service_type' => 'Catering & Hospitality',
            'contact' => 'Peter Mwangi',
            'email' => 'bookings@waridicatering.co.ke',
            'phone' => '0733123456',
            'address' => 'Ngong Road, Nairobi',
        ]);

        $vendor2 = Vendor::create([
            'name' => 'Sound Masters Kenya',
            'service_type' => 'Audio & Visual',
            'contact' => 'Sarah Ochieng',
            'email' => 'info@soundmasters.co.ke',
            'phone' => '0733123457',
            'address' => 'Mombasa Road, Nairobi',
        ]);

        $vendor3 = Vendor::create([
            'name' => 'Floral Designs Ltd',
            'service_type' => 'Decor & Floristry',
            'contact' => 'Grace Wanjiku',
            'email' => 'orders@floraldesigns.co.ke',
            'phone' => '0733123458',
            'address' => 'Westlands, Nairobi',
        ]);

        $vendor4 = Vendor::create([
            'name' => 'Classic Photography',
            'service_type' => 'Photography & Videography',
            'contact' => 'James Kimani',
            'email' => 'shoots@classicphoto.co.ke',
            'phone' => '0733123459',
            'address' => 'Karen, Nairobi',
        ]);

        $this->command->info('4 vendors created');

        // Create Events
        $event1 = Event::create([
            'title' => 'Johnson Wedding Reception',
            'client_id' => $client1->id,
            'event_date' => '2024-06-15',
            'location' => 'Karen Country Club, Nairobi',
            'budget' => 450000,
            'description' => 'Evening reception for 200 guests. Theme: Royal Blue & Gold.',
            'status' => 'confirmed',
            'user_id' => 1,
        ]);

        $event2 = Event::create([
            'title' => 'Safaricom 25th Anniversary Gala',
            'client_id' => $client2->id,
            'event_date' => '2024-10-20',
            'location' => 'KICC, Nairobi',
            'budget' => 2500000,
            'description' => 'Corporate gala dinner celebrating 25 years. 500 VIP guests.',
            'status' => 'planning',
            'user_id' => 1,
        ]);

        $event3 = Event::create([
            'title' => 'Nairobi Chapel Youth Conference',
            'client_id' => $client3->id,
            'event_date' => '2024-08-10',
            'location' => 'Nairobi Chapel, Lavington',
            'budget' => 150000,
            'description' => 'Annual youth conference. Expected 300 attendees.',
            'status' => 'planning',
            'user_id' => 1,
        ]);

        $event4 = Event::create([
            'title' => 'Corporate End Year Party',
            'client_id' => $client2->id,
            'event_date' => '2023-12-15',
            'location' => 'Radisson Blu, Upper Hill',
            'budget' => 800000,
            'description' => 'Staff end year celebration. Completed successfully.',
            'status' => 'completed',
            'user_id' => 1,
        ]);

        $this->command->info('4 events created');

        // Create Services for Event 1 (Johnson Wedding)
        Service::create([
            'event_id' => $event1->id,
            'vendor_id' => $vendor1->id,
            'name' => 'Full Catering Package',
            'cost' => 180000,
            'description' => '3-course meal for 200 guests, including service staff',
        ]);

        Service::create([
            'event_id' => $event1->id,
            'vendor_id' => $vendor2->id,
            'name' => 'PA System & DJ',
            'cost' => 45000,
            'description' => 'Full sound system, microphones, and DJ services',
        ]);

        Service::create([
            'event_id' => $event1->id,
            'vendor_id' => $vendor3->id,
            'name' => 'Venue Decoration',
            'cost' => 85000,
            'description' => 'Floral arrangements, draping, table settings',
        ]);

        Service::create([
            'event_id' => $event1->id,
            'vendor_id' => $vendor4->id,
            'name' => 'Photography Package',
            'cost' => 35000,
            'description' => 'Full day coverage, edited photos, photo album',
        ]);

        // Services for Event 2 (Safaricom)
        Service::create([
            'event_id' => $event2->id,
            'vendor_id' => $vendor1->id,
            'name' => 'VIP Catering',
            'cost' => 800000,
            'description' => 'Premium 5-course dinner for 500 guests',
        ]);

        Service::create([
            'event_id' => $event2->id,
            'vendor_id' => $vendor2->id,
            'name' => 'Stage & Audio Visual',
            'cost' => 350000,
            'description' => 'LED screens, stage lighting, concert sound system',
        ]);

        $this->command->info('6 services created');

        // Create Attendees for Event 1
        $attendees = [
            ['name' => 'Michael Johnson', 'email' => 'mike@email.com', 'phone' => '0711223344'],
            ['name' => 'Sarah Johnson', 'email' => 'sarah@email.com', 'phone' => '0711223345'],
            ['name' => 'David Kimani', 'email' => 'david@email.com', 'phone' => '0711223346'],
            ['name' => 'Grace Muthoni', 'email' => 'grace@email.com', 'phone' => '0711223347'],
            ['name' => 'Peter Njoroge', 'email' => 'peter@email.com', 'phone' => '0711223348'],
            ['name' => 'Mary Wanjiru', 'email' => 'mary@email.com', 'phone' => '0711223349'],
            ['name' => 'John Kamau', 'email' => 'john@email.com', 'phone' => '0711223350'],
            ['name' => 'Lucy Ochieng', 'email' => 'lucy@email.com', 'phone' => '0711223351'],
        ];

        foreach ($attendees as $attendee) {
            Attendee::create([
                'event_id' => $event1->id,
                'name' => $attendee['name'],
                'email' => $attendee['email'],
                'phone' => $attendee['phone'],
            ]);
        }

        $this->command->info('8 attendees created for Johnson Wedding');

        // Summary
        $this->command->info('=================================');
        $this->command->info('DEMO DATA SEEDED SUCCESSFULLY!');
        $this->command->info('=================================');
        $this->command->info('Clients: 3');
        $this->command->info('Vendors: 4');
        $this->command->info('Events: 4 (2 planning, 1 confirmed, 1 completed)');
        $this->command->info('Services: 6');
        $this->command->info('Attendees: 8');
        $this->command->info('=================================');
        $this->command->info('Login: admin@waridi.com / password');
    }
}