<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LeaderBoardController extends Controller
{
    public function index(Request $request)
    {
        $query = LeaderBoard::query();

        // Filter by date
        if ($request->has('filter')) {
            $filter = $request->input('filter');
            $date = now();

            if ($filter === 'day') {
                $query->whereDate('activity_time', $date->today());
            } elseif ($filter === 'month') {
                $query->whereYear('activity_time', $date->year)
                    ->whereMonth('activity_time', $date->month);
            } elseif ($filter === 'year') {
                $query->whereYear('activity_time', $date->year);
            }
        }

        // Search by user ID
        if ($request->has('search')) {
            $userId = $request->input('search');
            $query->where('user_id', $userId);
        }

        // Calculate rank
        $leaderboardData = $query->selectRaw('*, (SELECT COUNT(*) FROM leaderboards WHERE points > leaderboards.points) + 1 AS rank')
        ->orderBy('points', 'DESC')
        ->get();

        return view('leaderboard.index', compact('leaderboardData'));
    }

    public function recalculate()
    {
        // Logic to re-calculate ranks
        User::query()->update(['rank' => null]); // Reset ranks
        // Recalculate ranks
        $this->index(request());
    }
}
