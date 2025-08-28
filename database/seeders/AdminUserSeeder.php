<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'mohsinjaleel8@gmail.com'],
            [
                'name'              => 'Admin Mohsin',
                'password'          => Hash::make('Mohsin631@'),
                'is_admin'          => 1,
                'email_verified_at' => now(),
            ]
        );
    }
}
