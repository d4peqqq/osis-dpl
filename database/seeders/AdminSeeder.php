<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@osis.sch.id'],
            [
                'name' => 'Administrator OSIS',
                'password' => Hash::make('Osis0525#'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
