<?php

use App\Http\Controllers\LeaderBoardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LeaderBoardController::class, 'index'])->name('leaderboard.index');
Route::get('/leaderboard/recalculate', [LeaderBoardController::class, 'recalculate'])->name('leaderboard.recalculate');
