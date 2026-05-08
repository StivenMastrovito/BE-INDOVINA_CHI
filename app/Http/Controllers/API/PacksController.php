<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Character;
use App\Models\Pack;
use App\Models\Pack_Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PacksController extends Controller
{
    public function index()
    {
        $packs = Pack::all();
        $packs->load('pack_votes');

        return response()->json($packs);
    }

    public function show(Request $request)
    {
        $data = $request->validate([
            'pack_id' => 'required|integer|exists:packs,id',
        ]);

        $pack = Pack::find($data['pack_id']);

        $pack->load('characters');

        return response()->json(
            $pack
        );
    }

    public function addVote(Request $request)
    {
        $data = $request->validate([
            'id_pack' => 'required|integer|exists:packs,id',
            'vote' => 'required|integer|min:1|max:5',
        ]);

        $vote = new Pack_Vote();

        $vote->pack_id = $data['pack_id'];
        $vote->vote = $data['vote'];

        $vote->save();

        return response()->json(['message' => 'Vote added successfully']);
    }

    public function store(Request $request)
    {

        $data = $request->all();

        $newPack = new Pack();

        $newPack->name = $data['name'];
        if (array_key_exists('description', $data) && strlen($data['description']) > 5) {
            $newPack->description = $data['description'];
        }

        if (array_key_exists('background_url', $data)) {
            $url = Storage::disk('public')->putFile('images', $request->file('background_url'));
            $newPack->background_url = $url;
        }

        $newPack->save();


        $characters = $request->all()['characters'] ?? [];

        if (!empty($characters)) {
            foreach ($characters as $index => $character) {
                $newChar = new Character();
                $newChar->name = $character['name'];
                $newChar->pack_id = $newPack->id;
                if ($request->hasFile("characters.$index.image_url")) {
                    $url = Storage::disk('public')->putFile('images', $request->file("characters.$index.image_url"));
                    $newChar->image_url = $url;
                } else {
                    $newChar->image_url = 'images/fake_image.png';
                }
                $newChar->save();
            }
        }

        return response()->json([
            'message' => 'Pack created successfully',
            'pack' => $newPack,
        ]);
    }
}
