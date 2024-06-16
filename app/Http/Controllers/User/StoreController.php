<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StoreController extends Controller
{
    public function index(StoreRequest $req) {
        $data = $req->validated();
        $data["password"] = Hash::make($data["password"]);
        $user = User::firstOrCreate([
            "email" => $data["email"],
        ], $data);
        return new UserResource($user);
    }
}