<?php

namespace Database\Seeders;

use App\Models\CompanyInfo;
use Illuminate\Database\Seeder;

class CompanyInfoSeeder extends Seeder
{
    public function run(): void
    {
        CompanyInfo::firstOrCreate(
            ['id' => 1],
            [
                'company_name' => 'Gagan Dental & Aesthetics Clinic',
                'tagline' => 'Healthy Smiles, Confident You',
                'email' => 'info@gagandentalclinic.com',
                'country' => 'India',
                // Pre-installed brand files (see storage/app/public/company).
                'logo_path' => 'company/logo.png',
                'favicon_path' => 'company/favicon.png',
            ]
        );
    }
}
