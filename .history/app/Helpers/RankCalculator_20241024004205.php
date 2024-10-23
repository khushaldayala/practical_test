<?php

namespace App\Helpers;

use App\Models\User;

class RankCalculator
{
    public static function calculateRanks()
    {
        $users = User::orderBy('points', 'desc')->get();

        $currentRank = 1;
        $previousPoints = null;

        foreach ($users as $index => $user) {
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
