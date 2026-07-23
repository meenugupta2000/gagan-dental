<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        // Seed the lead doctor as a starting point (from the About section data).
        // Add the rest of the team from Admin → Our Team.
        TeamMember::firstOrCreate(
            ['name' => 'Dr. Gaganpreet Kaur'],
            [
                'designation' => 'Dental & Aesthetic Expert',
                'qualification' => 'Cosmetologist · FMC — Cosmetology · FAM (USA)',
                'sort_order' => 0,
                'is_active' => true,
            ]
        );
    }
}
