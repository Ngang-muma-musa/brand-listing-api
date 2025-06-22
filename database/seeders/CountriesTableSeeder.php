<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            [
                'name' => 'United States',
                'iso_alpha_2' => 'US',
                'is_active' => true,
            ],
            [
                'name' => 'Canada',
                'iso_alpha_2' => 'CA',
                'is_active' => true,
            ],
            [
                'name' => 'United Kingdom',
                'iso_alpha_2' => 'GB',
                'is_active' => true,
            ],
            [
                'name' => 'Germany',
                'iso_alpha_2' => 'DE',
                'is_active' => true,
            ],
            [
                'name' => 'France',
                'iso_alpha_2' => 'FR',
                'is_active' => true,
            ],
            [
                'name' => 'Cameroon',
                'iso_alpha_2' => 'CM',
                'is_active' => true,
            ],
            [
                'name' => 'Nigeria',
                'iso_alpha_2' => 'NG',
                'is_active' => true,
            ],
            [
                'name' => 'South Africa',
                'iso_alpha_2' => 'ZA',
                'is_active' => true,
            ],
        ];

        if (DB::table('countries')->count() == 0) {
            DB::table('countries')->insert($countries);
            $this->command->info('Countries seeded successfully!');
        } else {
            $this->command->info('Countries table already populated. Skipping seeding.');
        }
    }
}