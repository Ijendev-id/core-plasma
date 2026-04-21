<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::query()->firstOrNew([
            'email' => 'admin@coreplasma.test',
        ]);

        $admin->forceFill([
            'name' => 'Admin Core Plasma',
            'password' => 'password',
            'email_verified_at' => now(),
        ])->save();

        $this->call([
            MemberSeeder::class,
            LearningPackageSeeder::class,
            TryoutBackendSeeder::class,
        ]);
    }
}
