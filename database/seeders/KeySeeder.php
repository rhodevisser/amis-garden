<?php

namespace Database\Seeders;

use App\Models\Key;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KeySeeder extends Seeder
{
    /**
     * Seed the keys table with test registration keys
     *
     * This seeder creates some test keys for development
     * In production, you would create keys manually through Filament or artisan commands
     */
    public function run(): void
    {
        // Create 5 test keys
        // In real production, you'd want to generate these more securely
        // and distribute them to users individually

        $testKeys = [
            'TEST-2024-AMIS-0001',
            'TEST-2024-AMIS-0002',
            'TEST-2024-AMIS-0003',
            'TEST-2024-AMIS-0004',
            'TEST-2024-AMIS-0005',
        ];

        foreach ($testKeys as $keyValue) {
            // Create each key in the database
            // Only create if it doesn't already exist (in case we run seeder multiple times)
            Key::firstOrCreate(
                ['key' => $keyValue], // Search for this
                [
                    // These are the default values if creating new
                    'used_at' => null,
                    'used_by' => null,
                    'expires_at' => now()->addMonths(6), // Expires in 6 months
                ]
            );
        }

        $this->command->info('Created 5 test registration keys!');
        $this->command->info('You can use any of these to test registration:');
        foreach ($testKeys as $key) {
            $this->command->info('  - ' . $key);
        }
    }
}
