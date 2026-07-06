<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            CompanyInfoSeeder::class,
            EmailTemplatesSeeder::class,
            ClinicContentSeeder::class,
            AboutAndVideosSeeder::class,
            LegalPagesSeeder::class,
        ]);

        // Super Admin account.
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@gagandentalclinic.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Super@12345'),
                'is_active' => true,
            ]
        );
        $superAdmin->syncRoles(['super-admin']);

        // A regular Admin account for day-to-day use.
        $admin = User::firstOrCreate(
            ['email' => 'admin@gagandentalclinic.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('Admin@12345'),
                'is_active' => true,
            ]
        );
        $admin->syncRoles(['admin']);
    }
}
