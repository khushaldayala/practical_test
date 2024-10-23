<?php

namespace App\Http\Controllers;

use App\Helpers\RankCalculator;
use App\Models\User;
use Illuminate\Http\Request;

class LeaderBoardController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by date
        $date = now();

        if ($filter === 'day') {
            \Log::info('Applying day filter', ['date' => $date->toDateString()]);
            $query->whereDate('activity_time', $date->toDateString());
        } elseif ($filter === 'month') {
            \Log::info('Applying month filter', ['year' => $date->year, 'month' => $date->month]);
            $query->whereYear('activity_time', $date->year)
                ->whereMonth('activity_time', $date->month);
        } elseif ($filter === 'year') {
            \Log::info('Applying year filter', ['year' => $date->year]);
            $query->whereYear('activity_time', $date->year);
        }
    

        // Search by user ID
        if ($request->has('search')) {
            $userId = $request->input('search');
            $query->where('id', $userId);
        }

        // Calculate rank and get leaderboard data
        $leaderboardData = $query->get();

        // Check if the request is AJAX
        if ($request->ajax()) {
            return response()->json(['leaderboardData' => $leaderboardData]);
        }

        return view('welcome', compact('leaderboardData'));
    }

    public function recalculate()
    {
        RankCalculator::calculateRanks();

        return response()->json(['message' => 'Ranks recalculated successfully!']);
    }
}
