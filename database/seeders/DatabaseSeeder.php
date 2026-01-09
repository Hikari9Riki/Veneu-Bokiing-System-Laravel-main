<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Users (Data from your image)
        // Password is fixed to '123qweasd' for everyone
        $password = Hash::make('123qweasd');

        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Test User',
                'email' => 'test@example.com',
                'phone' => '0123456789',
                'role' => 'user',
                'password' => $password,
                'created_at' => '2026-01-07 18:18:55',
                'updated_at' => '2026-01-07 18:18:55',
            ],
            [
                'id' => 2,
                'name' => 'duwe',
                'email' => 'duwe@123',
                'phone' => '1110',
                'role' => 'user',
                'password' => $password,
                'created_at' => '2026-01-07 22:46:39',
                'updated_at' => '2026-01-07 22:46:39',
            ],
            [
                'id' => 3,
                'name' => 'duwe',
                'email' => 'duwe@321', // Note: Emails must be unique
                'phone' => '0111',
                'role' => 'user',
                'password' => $password,
                'created_at' => '2026-01-07 23:15:53',
                'updated_at' => '2026-01-07 23:15:53',
            ],
            [
                'id' => 4,
                'name' => 'Super Admin',
                'email' => 'admin@iium.edu.my',
                'phone' => '0123456789',
                'role' => 'admin',
                'password' => $password,
                'created_at' => '2026-01-08 10:04:28',
                'updated_at' => '2026-01-08 10:04:28',
            ],
        ]);

        // 2. Seed Venues (Data from your image)
        DB::table('venues')->insert([
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
        ]);

        // 3. Seed Reservations
        // I have filled in the NULL reasons with generic events as requested.
        DB::table('reservations')->insert([
            [
                'reservationID' => 'RES-ABC123',
                'date' => '2026-01-15',
                'startTime' => '10:00:00',
                'endTime' => '12:00:00',
                'reason' => 'Weekly Team Meeting',
                'status' => 'Approved',
                'venueID' => 'V001',
                'user_id' => 1,
                'created_at' => '2026-01-08 12:00:00',
                'updated_at' => '2026-01-08 12:00:00',
            ],
            [
                'reservationID' => 'RES-DEF456',
                'date' => '2026-01-20',
                'startTime' => '14:00:00',
                'endTime' => '16:00:00',
                'reason' => 'Project Presentation',
                'status' => 'Pending',
                'venueID' => 'V002',
                'user_id' => 2,
                'created_at' => '2026-01-08 13:00:00',
                'updated_at' => '2026-01-08 13:00:00',
            ],
        ]);
    }
}