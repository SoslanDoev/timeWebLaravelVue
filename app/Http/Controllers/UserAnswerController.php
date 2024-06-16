<?php

namespace App\Http\Controllers;
use App\Http\Resources\UserAnswerResource;
use App\Http\Requests\UserAnswer\StoreRequest;
use App\Models\UserAnswer;

use Illuminate\Http\Request;

class UserAnswerController extends Controller
{
    public function index() {
        return UserAnswerResource::collection(UserAnswer::all());
    }
    
    public function view($id) {
        return new UserAnswerResource(UserAnswer::findOrFail($id));
    }

    public function endQuest(Request $request) {
        $data = $request->all();
        $userID = null;
        foreach($data as $item) {
            if (isset($item['user_id'])) {
                $userID = $item["user_id"];
                continue;
            }
            $questionID = $item["question_id"];
            $answerID = $item["answer_id"];
            $data = UserAnswer::create([
                "user_id" => $userID,
                "question_id" => $questionID,
                "answer_id" => $answerID,
            ]);
        }
        return response()->json(["message" => "Успешно"]);
    }

    public function store(StoreRequest $req) {
        $valData = $req->validated();
        $data = UserAnswer::create($valData);
        return new UserAnswerResource($data);
    }

    public function update($id, StoreRequest $req) {
        $data = UserAnswer::find($id);
        if (!$data) 
            return response()->json(['message' => 'Не найдено'], 404);
        $valData = $req->validated();
        $data->update($valData);
        return response()->json($data);
    }

    public function destroy($id) {
        $data = UserAnswer::find($id);
        if (!$data) 
            return response()->json(['message' => 'Не найдено'], 404);
        $data->delete();
        return response()->json($data);
    }
}
