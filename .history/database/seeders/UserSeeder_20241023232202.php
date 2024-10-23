<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 50; $i++) {
            User::create([
                'user_id' => "user{$i}",
                'full_name' => "User {$i}",
                'points' => 20,
                'activity_time' => Carbon::now()->subDays(rand(0, 30)), // Random date in the last 30 days
            ]);
        }
    }
}
