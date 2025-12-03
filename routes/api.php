<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PuzzleController;
use App\Http\Controllers\Api\LeaderboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// create a puzzle
Route::post('/puzzles', [PuzzleController::class, 'store']);
// Student Submit Word
Route::post('/puzzles/{id}/submit', [PuzzleController::class, 'submitWord']);
// Leaderboard
Route::get('/leaderboard', [LeaderboardController::class, 'index']);

