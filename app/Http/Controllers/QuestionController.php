<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\QuestionResource;
use App\Http\Requests\Question\StoreRequest;
use App\Models\Question;

class QuestionController extends Controller
{
    public function index() {
        return QuestionResource::collection(Question::all());
    }
    
    public function view($id) {
        return new QuestionResource(Question::findOrFail($id));
    }

    public function store(StoreRequest $req) {
        $valData = $req->validated();
        $data = Question::create($valData);
        return response()->json($data);
    }

    public function update($id, StoreRequest $req) {
        $data = Question::find($id);
        if (!$data) 
            return response()->json(['message' => 'Не найдено'], 404);
        $valData = $req->validated();
        $data->update($valData);
        return response()->json($data);
    }

    public function destroy($id) {
        $data = Question::find($id);
        if (!$data) 
            return response()->json(['message' => 'Не найдено'], 404);
        $data->delete();
        return response()->json($data);
    }
}
