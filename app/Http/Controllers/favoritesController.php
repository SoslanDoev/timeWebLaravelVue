<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\FavoriteResource;
use App\Models\Favorites;

class favoritesController extends Controller
{
    public function index($user_id) {
        $res = Favorites::where("user_id", $user_id)->get();
        return FavoriteResource::collection($res);
    }

    public function view($user_id, $course_id) {
        $res = Favorites::where("user_id", $user_id)->where("course_id", $course_id)->first();
        if ($res) 
            return 1;
        return -1;
    }

    public function store(Request $req) {
        $data = Favorites::create([
            "user_id" => $req["user_id"],
            "course_id" => $req["course_id"],
        ]);
        return response()->json($data);
    }

    public function destroy($user_id, $course_id) {
        $res = Favorites::where("user_id", $user_id)->where("course_id", $course_id)->delete();
        if ($res) 
            return 1;
        return -1;
    }
}
