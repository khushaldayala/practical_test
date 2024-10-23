<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/leaderboard', [LeaderBoardController::class, 'index'])->name('leaderboard.index');
Route::get('/leaderboard/recalculate', [LeaderBoardController::class, 'recalculate'])->name('leaderboard.recalculate');
