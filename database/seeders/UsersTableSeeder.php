<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear the users table first
        User::truncate();

        // Create regular users
        User::create([
            'name' => 'User One',
            'email' => 'user1@test.com',
            'phone_number' => '70102030',
            'password' => Hash::make('user1234'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'User Two',
            'email' => 'user2@test.com',
            'phone_number' => '70203040',
            'password' => Hash::make('user1234'),
            'role' => 'user',
        ]);

        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'phone_number' => '70304050',
            'password' => Hash::make('admin1234'),
            'role' => 'admin',
        ]);
    }
}
