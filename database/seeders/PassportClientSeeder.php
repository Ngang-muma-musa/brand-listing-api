<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PassportClientSeeder extends Seeder
{
    public function run()
    {
        $personalAccessTokenClientId = "019798d0-cdd1-721d-b766-c31df41296b9";
        $personalAccessTokenClientName = 'Laravel Passport Personal Access Client';

        if (! DB::table('oauth_clients')->where('id', $personalAccessTokenClientId)->exists()) {
            DB::table('oauth_clients')->insert([
                'id' => $personalAccessTokenClientId,
                'owner_type' => null,
                'owner_id' => null,
                'name' => $personalAccessTokenClientName,
                'secret' => Hash::make('W5bqDGZVptLIwXJGuUTYKpJZwrdQ8Ug1iEaSMZJH'),
                'provider' => "users",
                'redirect_uris' => 'http://localhost',
                'grant_types' => 'personal_access',
                'revoked' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            $this->command->info($personalAccessTokenClientName . ' created successfully (custom schema).');
        } else {
            $this->command->info($personalAccessTokenClientName . ' already exists. Skipping creation.');
        }
    }
}