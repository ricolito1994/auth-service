<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $default_users = [
            [
                'name' => 'Ip Manager Superadmin',
                'email' => 'superadmin@ipmanager.com',
                'username' => 'superadmin',
                'password' => Hash::make('superadmin'),
                'is_super_admin' => true,
                'designation' => 'Super Admin'
            ],
            [
                'name' => 'User1',
                'email' => 'user@ipmanager.com',
                'username' => 'user1',
                'password' => Hash::make('user1'),
                'is_super_admin' => false,
                'designation' => 'User'
            ],
        ];

        foreach ($default_users as $default_user):
            User::firstOrCreate(['email' => $default_user['email']], 
                $default_user);
        endforeach;
    }
}
