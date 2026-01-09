<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VenueSeeder extends Seeder
{
    public function run()
    {
        DB::table('venues')->insert([
            // KICT
            ['name' => 'Main Auditorium', 'kuliyyah' => 'KICT', 'capacity' => 300, 'location' => 'Level 1, KICT Building', 'price' => 500.00],
            ['name' => 'Conference Room', 'kuliyyah' => 'KICT', 'capacity' => 50, 'location' => 'Level 5, KICT', 'price' => 150.00],
            ['name' => 'Al-Khawarizmi Lab', 'kuliyyah' => 'KICT', 'capacity' => 40, 'location' => 'Level 2, Block B', 'price' => 100.00],

            // KENMS
            ['name' => 'Lecture Hall 1', 'kuliyyah' => 'KENMS', 'capacity' => 200, 'location' => 'Ground Floor, KENMS', 'price' => 300.00],
            ['name' => 'Exam Hall', 'kuliyyah' => 'KENMS', 'capacity' => 150, 'location' => 'Level 3, KENMS', 'price' => 200.00],

            // KOE
            ['name' => 'Multipurpose Hall', 'kuliyyah' => 'KOE', 'capacity' => 500, 'location' => 'Block E1, Engineering', 'price' => 800.00],
            ['name' => 'Meeting Room 2', 'kuliyyah' => 'KOE', 'capacity' => 20, 'location' => 'Admin Building, KOE', 'price' => 50.00],

            // AIKOL
            ['name' => 'Moot Court', 'kuliyyah' => 'AIKOL', 'capacity' => 100, 'location' => 'Level 2, AIKOL', 'price' => 250.00],
            
            // IRKHS
            ['name' => 'Main Hall', 'kuliyyah' => 'IRKHS', 'capacity' => 400, 'location' => 'Level 1, IRKHS', 'price' => 400.00],
        ]);
    }
}