<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@atlasdigitalize.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('AtlasDigitalize@!23'),
                'email_verified_at' => now(),
            ]
        );

        // Seed all data
        $this->call([
            AboutPageSeeder::class,
            SolutionSeeder::class,
            ClientSeeder::class,
            ContactSeeder::class,
            InsightSeeder::class,
            ProjectSeeder::class,
        ]);
    }
}
