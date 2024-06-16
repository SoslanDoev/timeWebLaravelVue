<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\DisciplineResource;
use App\Http\Requests\Discipline\StoreRequest;
use App\Models\Discipline;

class DisciplineController extends Controller
{
    public function index() {
        return DisciplineResource::collection(Discipline::all());
    }

    public function view($id) {
        return new DisciplineResource(Discipline::findOrFail($id));
    }

    public function store(StoreRequest $req) {
        $valData = $req->validated();
        $data = Discipline::create($valData);
        return response()->json($data);
    }

    public function update($id, StoreRequest $req) {
        $data = Discipline::find($id);
        if (!$data) 
            return response()->json(['message' => 'Не найдено'], 404);
        $valData = $req->validated();
        $data->update($valData);
        return response()->json($data);
    }

    public function destroy($id) {
        $data = Discipline::find($id);
        if (!$data) 
            return response()->json(['message' => 'Не найдено'], 404);
        $data->delete();
        return response()->json($data);
    }

}
