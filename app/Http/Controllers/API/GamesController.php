<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Pack;
use App\Models\Player;
use Illuminate\Http\Request;

class GamesController extends Controller
{
    public function show(Request $request)
    {
        $room_code = $request->validate([
            'room_code' => 'required',
        ]);

        $game = Game::where('room_code', $room_code)->get();

        $game->load('questions', 'players');

        return response()->json($game);
    }

    public function generateAndStore(Request $request)
    {
        $request->validate([
            'pack_id' => 'required|integer|exists:packs,id',
        ]);

        $maxAttempts = 10;
        $roomCode = null;

        for ($i = 0; $i < $maxAttempts; $i++) {
            $candidate = strtoupper(substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 8));

            if (!Game::where('room_code', $candidate)->exists()) {
                $roomCode = $candidate;
                break;
            }
        }

        if (!$roomCode) {
            return response()->json(['message' => 'Impossibile generare un codice univoco'], 500);
        }

        $game = new Game();
        $game->pack_id = $request->pack_id;
        $game->room_code = $roomCode;
        $game->status = 'waiting';
        $game->save();

        Pack::where('id', $request->pack_id)->increment('count');

        return response()->json([
            'message' => 'Game created successfully',
            'room_code' => $roomCode,
            'game_id' => $game->id,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'room_code' => 'required|exists:games,room_code',
            'turn_player_id' => 'required|integer'
        ]);

        $game = Game::where('room_code', $data['room_code'])->first();

        $game->turn_player_id = $data['turn_player_id'];

        $game->update();

        return response()->json(['message' => 'Game updated successfully']);
    }

    public function updateStatus(Request $request)
    {
        $data = $request->validate([
            'room_code' => 'required|exists:games,room_code',
            'status' => 'required|string',
            'winner_id' => 'required|integer|exists:players,id',
        ]);

        $game = Game::where('room_code', $data['room_code'])->first();

        $game->status = $data['status'];
        $game->winner_id = $data['winner_id'];

        $game->update();

        return response()->json(['message' => 'Game updated successfully']);
    }

    public function updateOnlyStatus(Request $request)
    {
        $data = $request->validate([
            'game_id' => 'required|exists:games,id',
            'status' => 'required|string',
        ]);

        $game = Game::where('id', $data['game_id'])->first();

        $game->status = $data['status'];
        $game->save();

        return response()->json(['message' => 'Game updated successfully']);
    }

    public function guess(Request $request)
    {
        $data = $request->validate([
            'game_id' => 'required|integer|exists:games,id',
            'player_id' => 'required|integer|exists:players,id',
            'character_id' => 'required|integer|',
        ]);

        $player = Player::find($data['player_id']);

        $isCorrect = $player->character_id === (int)$data['character_id'];

        return response()->json(['correct' => $isCorrect]);
    }
}
