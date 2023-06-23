<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => '12345678'
        ]);

        $user->assignRole('Super Administrator');

        $user2 = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => '12345678'
        ]);

        $user2->assignRole('Administrator');

        $user3 = User::create([
            'name' => 'Agency',
            'email' => 'agency@gmail.com',
            'password' => '12345678'
        ]);

        $user3->assignRole('Agency');

        $user4 = User::create([
            'name' => 'Partner',
            'email' => 'partner@gmail.com',
            'password' => '12345678'
        ]);

        $user4->assignRole('Partner');

        $user5 = User::create([
            'name' => 'Ferdian Firmansyah',
            'email' => 'ferdianfy13@gmail.com',
            'password' => '12345678'
        ]);

        $user5->assignRole('Member');

        $user6 = User::create([
            'name' => 'Anik Kartika',
            'email' => 'anikkartika@gmail.com',
            'password' => '12345678'
        ]);

        $user6->assignRole('Member');

        $user7 = User::create([
            'name' => 'Auction Supervisor',
            'email' => 'supervisor@gmail.com',
            'password' => '12345678'
        ]);

        $user7->assignRole('Supervisor');
    }
}
