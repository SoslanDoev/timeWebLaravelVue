<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\AnswerResource;
use App\Http\Requests\Answer\StoreRequest;
use App\Models\Answer;

class AnswerController extends Controller
{
    public function index() {
        return AnswerResource::collection(Answer::all());
    }
    
    public function view($id) {
        return new AnswerResource(Answer::findOrFail($id));
    }

    public function store(StoreRequest $req) {
        $valData = $req->validated();
        $data = Answer::create($valData);
        return new AnswerResource($data);
    }

    public function update($id, StoreRequest $req) {
        $data = Answer::find($id);
        if (!$data) 
            return response()->json(['message' => 'Не найдено'], 404);
        $valData = $req->validated();
        $data->update($valData);
        return response()->json($data);
    }

    public function destroy($id) {
        $data = Answer::find($id);
        if (!$data) 
            return response()->json(['message' => 'Не найдено'], 404);
        $data->delete();
        return response()->json($data);
    }
}
