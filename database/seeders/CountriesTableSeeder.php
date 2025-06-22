<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CountriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            [
                'name' => 'United States',
                'iso_alpha_2' => 'US',
                'iso_alpha_3' => 'USA',
                'dialing_code' => '+1',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Canada',
                'iso_alpha_2' => 'CA',
                'iso_alpha_3' => 'CAN',
                'dialing_code' => '+1',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'United Kingdom',
                'iso_alpha_2' => 'GB',
                'iso_alpha_3' => 'GBR',
                'dialing_code' => '+44',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Germany',
                'iso_alpha_2' => 'DE',
                'iso_alpha_3' => 'DEU',
                'dialing_code' => '+49',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'France',
                'iso_alpha_2' => 'FR',
                'iso_alpha_3' => 'FRA',
                'dialing_code' => '+33',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Cameroon',
                'iso_alpha_2' => 'CM',
                'iso_alpha_3' => 'CMR',
                'dialing_code' => '+237',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Nigeria',
                'iso_alpha_2' => 'NG',
                'iso_alpha_3' => 'NGA',
                'dialing_code' => '+234',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'South Africa',
                'iso_alpha_2' => 'ZA',
                'iso_alpha_3' => 'ZAF',
                'dialing_code' => '+27',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        if (DB::table('countries')->count() === 0) {
            DB::table('countries')->insert($countries);
            $this->command->info('Countries seeded successfully!');
        } else {
            $this->command->info('Countries table already populated. Skipping seeding.');
        }
    }
}