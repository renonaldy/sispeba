<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::updateOrCreate(
            ['email' => 'admin@admin.test'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('reno123'),
                'role' => 'admin',
            ]
        );

         User::updateOrCreate(
            ['email' => 'reno@admin.test'],
            [
                'name' => 'Admin Three',
                'password' => Hash::make('reno123'),
                'role' => 'admin',
            ]
        );
    }
}
