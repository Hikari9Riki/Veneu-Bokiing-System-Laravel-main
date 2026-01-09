<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. Seed Users
        // ==========================================
        $password = Hash::make('123qweasd');

        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Test User',
                'email' => 'test@example.com',
                'phone' => '0123456789',
                'role' => 'user',
                'password' => $password,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'duwe',
                'email' => 'duwe@123',
                'phone' => '1110',
                'role' => 'user',
                'password' => $password,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'duwe_alt', // Changed name slightly to distinguish
                'email' => 'duwe@321',
                'phone' => '0111',
                'role' => 'user',
                'password' => $password,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Super Admin',
                'email' => 'admin@iium.edu.my',
                'phone' => '0123456789',
                'role' => 'admin',
                'password' => $password,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ==========================================
        // 2. Seed Venues
        // ==========================================
        DB::table('venues')->insert([
            // Existing Venues (from your first snippet)
            [
                'venueID' => 'V001',
                'name' => 'Main Hall',
                'kuliyyah' => 'KICT',
                'location' => 'Block A, Level 2',
                'capacity' => 300,
                'available' => 1,
            ],
            [
                'venueID' => 'V002',
                'name' => 'LR14',
                'kuliyyah' => 'KENMS',
                'location' => 'Block A, Level 4',
                'capacity' => 30,
                'available' => 1,
            ],
            [
                'venueID' => 'V003',
                'name' => 'LR14',
                'kuliyyah' => 'KICT',
                'location' => 'Block C, Level 2',
                'capacity' => 120,
                'available' => 1,
            ],

            // New Venues (from your second snippet) - IDs manually assigned
            [
                'venueID' => 'V004',
                'name' => 'Main Auditorium', 
                'kuliyyah' => 'KICT', 
                'location' => 'Level 1, KICT Building',
                'capacity' => 300, 
                'available' => 1,
            ],
            [
                'venueID' => 'V005',
                'name' => 'Conference Room', 
                'kuliyyah' => 'KICT', 
                'location' => 'Level 5, KICT',
                'capacity' => 50, 
                'available' => 1,
            ],
            [
                'venueID' => 'V006',
                'name' => 'Al-Khawarizmi Lab', 
                'kuliyyah' => 'KICT', 
                'location' => 'Level 2, Block B',
                'capacity' => 40, 
                'available' => 1,
            ],
            [
                'venueID' => 'V007',
                'name' => 'Lecture Hall 1', 
                'kuliyyah' => 'KENMS', 
                'location' => 'Ground Floor, KENMS',
                'capacity' => 200, 
                'available' => 1,
            ],
            [
                'venueID' => 'V008',
                'name' => 'Exam Hall', 
                'kuliyyah' => 'KENMS', 
                'location' => 'Level 3, KENMS',
                'capacity' => 150, 
                'available' => 1,
            ],
            [
                'venueID' => 'V009',
                'name' => 'Multipurpose Hall', 
                'kuliyyah' => 'KOE', 
                'location' => 'Block E1, Engineering',
                'capacity' => 500, 
                'available' => 1,
            ],
            [
                'venueID' => 'V010',
                'name' => 'Meeting Room 2', 
                'kuliyyah' => 'KOE', 
                'location' => 'Admin Building, KOE',
                'capacity' => 20, 
                'available' => 1,
            ],
            [
                'venueID' => 'V011',
                'name' => 'Moot Court', 
                'kuliyyah' => 'AIKOL', 
                'location' => 'Level 2, AIKOL',
                'capacity' => 100, 
                'available' => 1,
            ],
            [
                'venueID' => 'V012',
                'name' => 'Main Hall', 
                'kuliyyah' => 'IRKHS', 
                'location' => 'Level 1, IRKHS',
                'capacity' => 400, 
                'available' => 1,
            ],
        ]);

        // ==========================================
        // 3. Seed Reservations
        // ==========================================
        DB::table('reservations')->insert([
            [
                'reservationID' => 'RES-ABC123',
                // Updated to match new startDate/endDate columns
                'startDate' => '2026-01-15',
                'endDate' => '2026-01-15',
                'startTime' => '10:00:00',
                'endTime' => '12:00:00',
                'reason' => 'Weekly Team Meeting',
                'status' => 'Approved',
                'venueID' => 'V001',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'reservationID' => 'RES-DEF456',
                // Updated to match new startDate/endDate columns
                'startDate' => '2026-01-20',
                'endDate' => '2026-01-20',
                'startTime' => '14:00:00',
                'endTime' => '16:00:00',
                'reason' => 'Project Presentation',
                'status' => 'Pending',
                'venueID' => 'V002',
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}