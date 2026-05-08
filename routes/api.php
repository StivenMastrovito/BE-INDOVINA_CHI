<?php

use App\Http\Controllers\API\GamesController;
use App\Http\Controllers\API\PacksController;
use App\Http\Controllers\API\PlayersController;
use App\Http\Controllers\API\QuestionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('games')->controller(GamesController::class)->group(function () {
    Route::post('store', 'store');
    Route::post('guess', 'guess');
    Route::post('update', 'update');
    Route::post('update/status', 'updateStatus');
    Route::post('update/only/status', 'updateOnlyStatus');
    Route::post('control', 'show');
    Route::get('check/{room_code}', 'checkRoomCode');
});

Route::prefix('packs')->controller(PacksController::class)->group(function (){
    Route::get('/', 'index');
    Route::post('/', 'show');
    Route::post('/addVote', 'addVote');
    Route::post('/store', 'store');
});

Route::prefix('players')->controller(PlayersController::class)->group(function (){
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


