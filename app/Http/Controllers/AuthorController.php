<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\AuthorResource;
use App\Http\Requests\Author\StoreRequest;
use App\Models\Author;

class AuthorController extends Controller
{
    public function index() {
        return AuthorResource::collection(Author::all());
    }
    
    public function view($id) {
        return new AuthorResource(Author::findOrFail($id));
    }

    public function store(StoreRequest $req) {
        $valData = $req->validated();
        $data = Author::create($valData);
        return response()->json($data);
    }

    public function update($id, StoreRequest $req) {
        $data = Author::find($id);
        if (!$data) 
            return response()->json(['message' => 'Не найдено'], 404);
        $valData = $req->validated();
        $data->update($valData);
        return response()->json($data);
    }

    public function destroy($id) {
        $data = Author::find($id);
        if (!$data) 
            return response()->json(['message' => 'Не найдено'], 404);
        $data->delete();
        return response()->json($data);
    }
}