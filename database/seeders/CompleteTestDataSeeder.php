<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Client;
use App\Models\Vendor;
use App\Models\Event;
use App\Models\Service;
use App\Models\Attendee;

class CompleteTestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks to allow truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear all tables (except users which we'll update)
        DB::table('services')->truncate();
        DB::table('attendees')->truncate();
        DB::table('events')->truncate();
        DB::table('vendors')->truncate();
        DB::table('clients')->truncate();
        
        // Delete non-essential users (keep if you want, or delete all)
        DB::table('users')->where('email', '!=', 'admin@waridi.com')->delete();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('All tables cleared. Inserting fresh data...');

        // ============================================
        // 1. CREATE CLIENTS (4 clients)
        // ============================================
        $clients = [
            Client::create([
                'name' => 'Safaricom PLC',
                'email' => 'events@safaricom.co.ke',
                'phone' => '0722000000',
                'address' => 'Safaricom House, Nairobi',
            ]),
            Client::create([
                'name' => 'Johnson Wedding Party',
                'email' => 'johnson.family@email.com',
                'phone' => '0712345678',
                'address' => 'Karen, Nairobi',
            ]),
            Client::create([
                'name' => 'KCA University',
                'email' => 'admin@kca.ac.ke',
                'phone' => '0700123456',
                'address' => 'KCA University, Nairobi',
            ]),
            Client::create([
                'name' => 'Nairobi Tech Summit',
                'email' => 'info@nairobitech.com',
                'phone' => '0733456789',
                'address' => 'Westlands, Nairobi',
            ]),
        ];

        $this->command->info('✓ 4 clients created');

        // ============================================
        // 2. CREATE VENDORS (6 vendors)
        // ============================================
        $vendors = [
            Vendor::create([
                'name' => 'Waridi Catering Services',
                'service_type' => 'Catering',
                'contact' => 'Mary Wanjiku',
                'email' => 'bookings@waridicatering.co.ke',
                'phone' => '0722123456',
                'address' => 'Industrial Area, Nairobi',
            ]),
            Vendor::create([
                'name' => 'Sound Masters Kenya',
                'service_type' => 'Sound & DJ',
                'contact' => 'DJ Kevo',
                'email' => 'info@soundmasters.co.ke',
                'phone' => '0733123456',
                'address' => 'Ngong Road, Nairobi',
            ]),
            Vendor::create([
                'name' => 'Floral Designs Ltd',
                'service_type' => 'Decoration',
                'contact' => 'Grace Muthoni',
                'email' => 'grace@floraldesigns.co.ke',
                'phone' => '0711123456',
                'address' => 'Lavington, Nairobi',
            ]),
            Vendor::create([
                'name' => 'Classic Photography',
                'service_type' => 'Photography',
                'contact' => 'James Ochieng',
                'email' => 'bookings@classicphoto.co.ke',
                'phone' => '0744123456',
                'address' => 'Kilimani, Nairobi',
            ]),
            Vendor::create([
                'name' => 'Luxury Transport',
                'service_type' => 'Transport',
                'contact' => 'Peter Kamau',
                'email' => 'info@luxurytransport.co.ke',
                'phone' => '0755123456',
                'address' => 'Mombasa Road, Nairobi',
            ]),
            Vendor::create([
                'name' => 'Elite Security',
                'service_type' => 'Security',
                'contact' => 'John Maina',
                'email' => 'security@elitesecurity.co.ke',
                'phone' => '0766123456',
                'address' => 'Karen, Nairobi',
            ]),
        ];

        $this->command->info('✓ 6 vendors created');

        // ============================================
        // 3. CREATE USERS (All 5 roles)
        // ============================================
        
        // Admin (update if exists, create if not)
        User::updateOrCreate(
            ['email' => 'admin@waridi.com'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '0700000001',
            ]
        );

        // Manager
        User::create([
            'name' => 'Event Manager',
            'email' => 'manager@waridi.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'phone' => '0700000002',
        ]);

        // Staff (2 staff members)
        $staff1 = User::create([
            'name' => 'Staff Member 1',
            'email' => 'staff1@waridi.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'phone' => '0700000003',
        ]);
        
        $staff2 = User::create([
            'name' => 'Staff Member 2',
            'email' => 'staff2@waridi.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'phone' => '0700000004',
        ]);

        // Client Users (linked to clients)
        User::create([
            'name' => 'Safaricom Events Manager',
            'email' => 'client@safaricom.co.ke',
            'password' => Hash::make('password'),
            'role' => 'client',
            'client_id' => $clients[0]->id,
            'phone' => '0722000001',
        ]);

        User::create([
            'name' => 'Johnson Family Rep',
            'email' => 'client@johnson.wedding',
            'password' => Hash::make('password'),
            'role' => 'client',
            'client_id' => $clients[1]->id,
            'phone' => '0712345679',
        ]);

        // Vendor Users (linked to vendors)
        User::create([
            'name' => 'Waridi Catering Admin',
            'email' => 'vendor@waridicatering.co.ke',
            'password' => Hash::make('password'),
            'role' => 'vendor',
            'vendor_id' => $vendors[0]->id,
            'phone' => '0722123457',
        ]);

        User::create([
            'name' => 'Sound Masters Admin',
            'email' => 'vendor@soundmasters.co.ke',
            'password' => Hash::make('password'),
            'role' => 'vendor',
            'vendor_id' => $vendors[1]->id,
            'phone' => '0733123457',
        ]);

        $this->command->info('✓ 8 users created (all roles)');

        // ============================================
        // 4. CREATE EVENTS (6 events with different statuses)
        // ============================================
        
        // Event 1: Safaricom - Completed (good for history)
        $event1 = Event::create([
            'title' => 'Safaricom 25th Anniversary Gala',
            'client_id' => $clients[0]->id,
            'event_date' => '2024-10-15',
            'location' => 'KICC, Nairobi',
            'budget' => 2500000,
            'description' => 'Corporate anniversary celebration with 500 guests',
            'status' => 'completed',
            'user_id' => 1,
            'assigned_to' => $staff1->id,
            'client_approved' => true,
            'client_approved_at' => '2024-09-01 10:00:00',
        ]);

        // Event 2: Johnson Wedding - Completed
        $event2 = Event::create([
            'title' => 'Johnson Wedding Reception',
            'client_id' => $clients[1]->id,
            'event_date' => '2024-06-20',
            'location' => 'Karen Country Club',
            'budget' => 800000,
            'description' => 'Wedding reception for 200 guests',
            'status' => 'completed',
            'user_id' => 1,
            'assigned_to' => $staff2->id,
            'client_approved' => true,
            'client_approved_at' => '2024-05-15 14:30:00',
        ]);

        // Event 3: KCA - Confirmed (upcoming)
        $event3 = Event::create([
            'title' => 'KCA Graduation Ceremony 2025',
            'client_id' => $clients[2]->id,
            'event_date' => '2025-07-15',
            'location' => 'KCA University Grounds',
            'budget' => 500000,
            'description' => 'Annual graduation ceremony',
            'status' => 'confirmed',
            'user_id' => 1,
            'assigned_to' => $staff1->id,
            'client_approved' => true,
            'client_approved_at' => now()->subDays(10),
        ]);

        // Event 4: Tech Summit - Planning (needs approval)
        $event4 = Event::create([
            'title' => 'Nairobi Tech Summit 2025',
            'client_id' => $clients[3]->id,
            'event_date' => '2025-08-20',
            'location' => 'Sarit Centre',
            'budget' => 1200000,
            'description' => 'Annual technology conference',
            'status' => 'planning',
            'user_id' => 1,
            'assigned_to' => $staff2->id,
            'client_approved' => false,
        ]);

        // Event 5: Safaricom - Ongoing (current event)
        $event5 = Event::create([
            'title' => 'Safaricom Product Launch',
            'client_id' => $clients[0]->id,
            'event_date' => now()->addDays(5)->format('Y-m-d'),
            'location' => 'Safaricom House',
            'budget' => 600000,
            'description' => 'New product launch event',
            'status' => 'ongoing',
            'user_id' => 1,
            'assigned_to' => $staff1->id,
            'client_approved' => true,
            'client_approved_at' => now()->subDays(20),
        ]);

        // Event 6: Johnson - Planning (over budget scenario)
        $event6 = Event::create([
            'title' => 'Johnson Family Reunion',
            'client_id' => $clients[1]->id,
            'event_date' => '2025-12-25',
            'location' => 'Windsor Hotel',
            'budget' => 300000,
            'description' => 'Annual family reunion dinner',
            'status' => 'planning',
            'user_id' => 1,
            'assigned_to' => $staff2->id,
            'client_approved' => false,
        ]);

        $this->command->info('✓ 6 events created');

        // ============================================
        // 5. CREATE SERVICES (with costs)
        // ============================================
        
        // Services for Event 1 (Safaricom - completed, over budget)
        Service::create([
            'event_id' => $event1->id,
            'vendor_id' => $vendors[0]->id, // Waridi Catering
            'name' => 'Full Catering Package (500 guests)',
            'cost' => 1200000,
            'description' => 'Complete catering with drinks',
        ]);
        Service::create([
            'event_id' => $event1->id,
            'vendor_id' => $vendors[1]->id, // Sound Masters
            'name' => 'Sound System & DJ',
            'cost' => 350000,
            'description' => 'Full PA system and DJ services',
        ]);
        Service::create([
            'event_id' => $event1->id,
            'vendor_id' => $vendors[2]->id, // Floral Designs
            'name' => 'Venue Decoration',
            'cost' => 450000,
            'description' => 'Full venue decoration',
        ]);
        Service::create([
            'event_id' => $event1->id,
            'vendor_id' => $vendors[3]->id, // Photography
            'name' => 'Event Photography',
            'cost' => 280000,
            'description' => 'Full event coverage',
        ]);
        // Total: 2,280,000 (over 2.5M budget? No, under. Let me adjust)
        // Actually 2.28M < 2.5M, so add more to make it over budget
        Service::create([
            'event_id' => $event1->id,
            'vendor_id' => $vendors[4]->id, // Transport
            'name' => 'VIP Transport',
            'cost' => 300000,
            'description' => 'Transport for VIP guests',
        ]);
        // Total now: 2,580,000 (over 2.5M budget by 80k) - shows red alert!

        // Services for Event 2 (Johnson Wedding - completed, good budget)
        Service::create([
            'event_id' => $event2->id,
            'vendor_id' => $vendors[0]->id,
            'name' => 'Wedding Catering (200 guests)',
            'cost' => 350000,
        ]);
        Service::create([
            'event_id' => $event2->id,
            'vendor_id' => $vendors[1]->id,
            'name' => 'Wedding DJ & MC',
            'cost' => 80000,
        ]);
        Service::create([
            'event_id' => $event2->id,
            'vendor_id' => $vendors[2]->id,
            'name' => 'Wedding Decorations',
            'cost' => 180000,
        ]);
        Service::create([
            'event_id' => $event2->id,
            'vendor_id' => $vendors[3]->id,
            'name' => 'Wedding Photography',
            'cost' => 120000,
        ]);
        // Total: 730,000 < 800,000 (good, green status)

        // Services for Event 3 (KCA - confirmed)
        Service::create([
            'event_id' => $event3->id,
            'vendor_id' => $vendors[0]->id,
            'name' => 'Graduation Lunch',
            'cost' => 250000,
        ]);
        Service::create([
            'event_id' => $event3->id,
            'vendor_id' => $vendors[1]->id,
            'name' => 'Sound System',
            'cost' => 100000,
        ]);
        // Total: 350,000 < 500,000 (green, room for more)

        // Services for Event 4 (Tech Summit - planning, no vendor assigned yet)
        Service::create([
            'event_id' => $event4->id,
            'vendor_id' => null, // No vendor assigned - shows in "unassigned" list
            'name' => 'Catering (TBD)',
            'cost' => 400000,
        ]);
        Service::create([
            'event_id' => $event4->id,
            'vendor_id' => $vendors[1]->id,
            'name' => 'AV Equipment',
            'cost' => 200000,
        ]);

        // Services for Event 5 (Safaricom Launch - ongoing)
        Service::create([
            'event_id' => $event5->id,
            'vendor_id' => $vendors[0]->id,
            'name' => 'Launch Event Catering',
            'cost' => 300000,
        ]);
        Service::create([
            'event_id' => $event5->id,
            'vendor_id' => $vendors[3]->id,
            'name' => 'Product Photography',
            'cost' => 150000,
        ]);

        // Services for Event 6 (Johnson Reunion - planning, will be over budget)
        Service::create([
            'event_id' => $event6->id,
            'vendor_id' => $vendors[0]->id,
            'name' => 'Dinner Catering',
            'cost' => 200000,
        ]);
        Service::create([
            'event_id' => $event6->id,
            'vendor_id' => $vendors[2]->id,
            'name' => 'Venue Setup',
            'cost' => 120000,
        ]);
        // Total: 320,000 > 300,000 (over budget by 20k - shows warning)

        $this->command->info('✓ 16 services created');

        // ============================================
        // 6. CREATE ATTENDEES (with RSVP statuses)
        // ============================================
        
        // Attendees for Event 1 (Safaricom - mix of statuses)
        $attendees1 = [
            ['name' => 'Peter Ndegwa', 'email' => 'ceo@safaricom.co.ke', 'phone' => '0722000001', 'rsvp' => 'confirmed'],
            ['name' => 'John Doe', 'email' => 'john@company.com', 'phone' => '0711111111', 'rsvp' => 'confirmed'],
            ['name' => 'Jane Smith', 'email' => 'jane@company.com', 'phone' => '0722222222', 'rsvp' => 'confirmed'],
            ['name' => 'Mike Johnson', 'email' => 'mike@test.com', 'phone' => '0733333333', 'rsvp' => 'pending'],
            ['name' => 'Sarah Wilson', 'email' => 'sarah@test.com', 'phone' => '0744444444', 'rsvp' => 'declined'],
            ['name' => 'David Brown', 'email' => 'david@company.com', 'phone' => '0755555555', 'rsvp' => 'confirmed'],
            ['name' => 'Emma Davis', 'email' => 'emma@company.com', 'phone' => '0766666666', 'rsvp' => 'pending'],
            ['name' => 'Chris Miller', 'email' => 'chris@test.com', 'phone' => '0777777777', 'rsvp' => 'confirmed'],
        ];
        foreach ($attendees1 as $a) {
            Attendee::create([
                'event_id' => $event1->id,
                'name' => $a['name'],
                'email' => $a['email'],
                'phone' => $a['phone'],
                'rsvp_status' => $a['rsvp'],
                'access_token' => bin2hex(random_bytes(16)),
            ]);
        }

        // Attendees for Event 2 (Johnson Wedding)
        $attendees2 = [
            ['name' => 'Uncle Bob', 'email' => 'bob@family.com', 'rsvp' => 'confirmed'],
            ['name' => 'Aunt Mary', 'email' => 'mary@family.com', 'rsvp' => 'confirmed'],
            ['name' => 'Cousin Tom', 'email' => 'tom@family.com', 'rsvp' => 'confirmed'],
            ['name' => 'Friend Lisa', 'email' => 'lisa@email.com', 'rsvp' => 'pending'],
            ['name' => 'Neighbor James', 'email' => 'james@email.com', 'rsvp' => 'confirmed'],
        ];
        foreach ($attendees2 as $a) {
            Attendee::create([
                'event_id' => $event2->id,
                'name' => $a['name'],
                'email' => $a['email'],
                'phone' => $a['phone'] ?? null,
                'rsvp_status' => $a['rsvp'],
                'access_token' => bin2hex(random_bytes(16)),
            ]);
        }

        // Attendees for Event 3 (KCA Graduation - many students)
        for ($i = 1; $i <= 50; $i++) {
            Attendee::create([
                'event_id' => $event3->id,
                'name' => 'Student ' . $i,
                'email' => 'student' . $i . '@kca.ac.ke',
                'phone' => '07' . rand(10000000, 99999999),
                'rsvp_status' => rand(0, 10) > 3 ? 'confirmed' : 'pending', // 70% confirmed
                'access_token' => bin2hex(random_bytes(16)),
            ]);
        }

        // Attendees for Event 4 (Tech Summit)
        for ($i = 1; $i <= 30; $i++) {
            Attendee::create([
                'event_id' => $event4->id,
                'name' => 'Delegate ' . $i,
                'email' => 'delegate' . $i . '@tech.com',
                'phone' => '07' . rand(10000000, 99999999),
                'rsvp_status' => 'pending', // All pending (not approved yet)
                'access_token' => bin2hex(random_bytes(16)),
            ]);
        }

        $this->command->info('✓ 93 attendees created');

        // ============================================
        // SUMMARY
        // ============================================
        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('TEST DATA CREATED SUCCESSFULLY!');
        $this->command->info('========================================');
        $this->command->info('');
        $this->command->info('LOGIN CREDENTIALS:');
        $this->command->info('------------------');
        $this->command->info('Admin:     admin@waridi.com / password');
        $this->command->info('Manager:   manager@waridi.com / password');
        $this->command->info('Staff 1:   staff1@waridi.com / password');
        $this->command->info('Staff 2:   staff2@waridi.com / password');
        $this->command->info('Client 1:  client@safaricom.co.ke / password (Safaricom)');
        $this->command->info('Client 2:  client@johnson.wedding / password (Johnson Wedding)');
        $this->command->info('Vendor 1:  vendor@waridicatering.co.ke / password (Catering)');
        $this->command->info('Vendor 2:  vendor@soundmasters.co.ke / password (Sound)');
        $this->command->info('');
        $this->command->info('TEST SCENARIOS:');
        $this->command->info('------------------');
        $this->command->info('• Event 1: Over budget (red alert) - Safaricom Gala');
        $this->command->info('• Event 2: Good budget (green) - Johnson Wedding');
        $this->command->info('• Event 4: Unassigned vendors (manager alert)');
        $this->command->info('• Event 6: Pending client approval');
        $this->command->info('• Staff 1: Assigned to 3 events');
        $this->command->info('• Staff 2: Assigned to 3 events');
        $this->command->info('========================================');
    }
}