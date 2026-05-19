<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\API\GamesController;
use App\Http\Controllers\API\PacksController;
use App\Http\Controllers\API\PlayersController;
use App\Http\Controllers\API\QuestionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'me']);
});


Route::prefix('games')->controller(GamesController::class)->group(function () {
    // Route::post('store', 'store');
    Route::post('guess', 'guess');
    Route::post('update', 'update');
    Route::post('update/status', 'updateStatus');
    Route::post('update/only/status', 'updateOnlyStatus');
    Route::post('control', 'show');
    Route::post('generate', 'generateAndStore');
});

Route::prefix('packs')->controller(PacksController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'show');
    Route::post('/addVote', 'addVote');
    Route::post('/store', 'store');
    Route::post('/mypacks', 'personalPacks');
    Route::post('/delete', 'destroy');
});

Route::prefix('players')->controller(PlayersController::class)->group(function () {
    Route::post('/store', 'store');
    Route::post('/secret-character', 'getSecretCharacter');
    Route::post('/control', 'show');
    Route::put('/update/characters', 'updateCharactersID');
});

Route::prefix('questions')->controller(QuestionsController::class)->group(function () {
    Route::post('/', 'index');
    Route::post('/store', 'store');
    Route::put('/answer', 'update');
});
