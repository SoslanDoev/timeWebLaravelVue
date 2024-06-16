<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\GroupResource;
use App\Http\Requests\Group\StoreRequest;
use App\Models\Group;

class GroupController extends Controller
{
    public function index() {
        return GroupResource::collection(Group::all());
    }
    
    public function view($id) {
        return new GroupResource(Group::findOrFail($id));
    }

    public function store(StoreRequest $req) {
        $valData = $req->validated();
        $data = Group::create($valData);
        return response()->json($data);
    }

    public function update($id, StoreRequest $req) {
        $data = Group::find($id);
        if (!$data) 
            return response()->json(['message' => 'Не найдено'], 404);
        $valData = $req->validated();
        $data->update($valData);
        return response()->json($data);
    }

    public function destroy($id) {
        $data = Group::find($id);
        if (!$data) 
            return response()->json(['message' => 'Не найдено'], 404);
        $data->delete();
        return response()->json($data);
    }
}
