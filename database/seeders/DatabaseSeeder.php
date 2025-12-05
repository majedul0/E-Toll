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
        User::factory()->create([
            'name' => 'Demo Citizen',
            'phone' => '01711111111',
            'email' => 'citizen@example.com',
            'nid' => '1234567890',
            'role' => 'citizen',
            'password' => Hash::make('Citizen@123'),
        ]);

        User::create([
            'name' => 'Toll Official',
            'phone' => '01700000000',
            'email' => 'official@etoll.gov.bd',
            'nid' => 'OFFICIAL0001',
            'role' => 'official',
            'official_department' => 'Roads and Highways',
            'password' => Hash::make('Admin@123'),
        ]);
    }
}
