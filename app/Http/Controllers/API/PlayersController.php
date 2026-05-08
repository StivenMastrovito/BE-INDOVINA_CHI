<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Character;
use App\Models\Player;
use Illuminate\Http\Request;

class PlayersController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'nickname' => 'required|string',
            'game_id' => 'required|integer|exists:games,id',
            'character_id' => 'required|integer|exists:characters,id'
        ]);

        $newPlayer = new Player();

        $newPlayer->game_id = $data['game_id'];
        $newPlayer->nickname = $data['nickname'];
        $newPlayer->character_id = $data['character_id'];
        $newPlayer->is_ready = true;

        $newPlayer->save();

        return response()->json(['message' => 'Player created successfully', 'player_id' => $newPlayer->id]);
    }

    public function show(Request $request){
        $data = $request->validate(['game_id' => 'required|integer|exists:games,id',]);

        $players = Player::where('game_id', $data['game_id'])->get();

        return response()->json($players);
    }

    public function updateCharactersID(Request $request){
        $data = $request->validate([
            'character_id' => 'required|integer',
            'player_id' => 'required|integer|exists:players,id',
        ]);

        $player = Player::find($data['player_id']);

        $player->character_id = $data['character_id'];

        $player->update();

        return response()->json([
            'message' => 'Character ID updated successfully'
        ]);
    }

    public function getSecretCharacter(Request $request){
        $data = $request->validate([
            'player_id' => 'required|integer|exists:players,id'
        ]);

        $player = Player::find($data['player_id'])->load('character');

        return response()->json([$player]);


    }
}
