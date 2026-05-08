<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function index(Request $request){
        $data = $request->validate([
            'game_id' => 'required|integer|exists:games,id',
        ]);

        $questions = Question::where('game_id', $data['game_id'])->get();

        return response()->json($questions);
    }

    public function store(Request $request){
        $data = $request->validate([
            'game_id' => 'required|integer|exists:games,id',
            'player_id' => 'required|integer|exists:players,id',
            'question' => 'required|string',
        ]);

        $newQuestion = new Question();

        $newQuestion->game_id = $data['game_id'];
        $newQuestion->player_id = $data['player_id'];
        $newQuestion->question = $data['question'];

        $newQuestion->save();

        return response()->json([
            'message' => 'Question created successfullt',
            'question_id' => $newQuestion->id
        ]);
    }

    public function update(Request $request){
        $data = $request->validate([
            'question_id' => 'required|integer|exists:questions,id',
            'answer' => 'required|string',
        ]);

        $question = Question::find($data['question_id']);

        $question->answer = $data['answer'];

        $question->update();

        return response()->json(['message' => 'Question updated successfully']);
        
    }
}
