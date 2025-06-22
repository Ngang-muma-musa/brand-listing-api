<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminUserData = [
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $existingAdmin = DB::table('users')->where('email', $adminUserData['email'])->first();

        if (is_null($existingAdmin)) {
            DB::table('users')->insert($adminUserData);
            $this->command->info('Admin user created successfully!');
        } else {
            $this->command->info('Admin user already exists. Skipping creation.');
        }
    }
}