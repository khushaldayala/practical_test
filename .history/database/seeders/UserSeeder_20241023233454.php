<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Helpers\RankCalculator

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => "User {$i}",
                'points' => rand(10000, 99999),
                'activity_time' => Carbon::now()->subDays(rand(0, 30)), // Random date in the last 30 days
            ]);
        }

        // Now calculate ranks
        $this->calculateRanks();
    }

    protected function calculateRanks()
    {
        // Fetch all users sorted by points in descending order
        $users = User::orderBy('points', 'desc')->get();

        $currentRank = 1;
        $previousPoints = null;

        foreach ($users as $index => $user) {
            // If the points are the same as the previous user, assign the same rank
            if ($previousPoints !== null && $user->points === $previousPoints) {
                $rank = $currentRank; // Same rank
            } else {
                $rank = $index + 1; // Assign a new rank
            }

            // Update the user's rank
            $user->rank = $rank;
            $user->save();

            // Update previous points and current rank
            $previousPoints = $user->points;
            $currentRank = $rank; // Update the current rank for next iteration
        }
    }
}
