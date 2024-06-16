<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\StoreController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;


use App\Http\Controllers\GroupController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TestScheduleController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\UserAnswerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(["middleware" => "api", "prefix" => "auth"], function ($router) {
    Route::post("login", [AuthController::class, "login"]);
    Route::post("logout", [AuthController::class, "logout"]);
    Route::post("refresh", [AuthController::class, "refresh"]);
    Route::post("me", [AuthController::class, "me"]);

    // Route::group(["namespace" => "api", "prefix" => "test"], function ($router) {
    //     Route::get("/", [TestController::class, "index"]);
    // });
});

Route::group(["namespace" => "User", "prefix" => "users"], function() {
    // Регистрация пользователя
    Route::post("/", [StoreController::class, "index"]);
    
    Route::get("/", [UserController::class, "index"]);
    Route::get("/{id}", [UserController::class, "view"]);
    Route::patch("/{id}", [UserController::class, "update"]);
    // Обновление
    Route::delete("/{id}", [UserController::class, "destroy"]);
});

Route::group(["namespace" => "Group", "prefix" => "groups"], function() {
    Route::get("/", [GroupController::class, "index"]);
    Route::post("/", [GroupController::class, "store"]);
    Route::get("/{id}", [GroupController::class, "view"]);
    Route::patch("/{id}", [GroupController::class, "update"]);
    Route::delete("/{id}", [GroupController::class, "destroy"]);
});

Route::group(["namespace" => "Discipline", "prefix" => "disciplines"], function() {
    Route::get("/", [DisciplineController::class, "index"]);
    Route::post("/", [DisciplineController::class, "store"]);
    Route::get("/{id}", [DisciplineController::class, "view"]);
    Route::patch("/{id}", [DisciplineController::class, "update"]);
    Route::delete("/{id}", [DisciplineController::class, "destroy"]);
});

Route::group(["namespace" => "Author", "prefix" => "authors"], function() {
    Route::get("/", [AuthorController::class, "index"]);
    Route::post("/", [AuthorController::class, "store"]);
    Route::get("/{id}", [AuthorController::class, "view"]);
    Route::patch("/{id}", [AuthorController::class, "update"]);
    Route::delete("/{id}", [AuthorController::class, "destroy"]);
});

Route::group(["namespace" => "Test", "prefix" => "tests"], function() {
    Route::post('/setall', [TestController::class, 'setTestQuestionsAndAnwsers']);

    Route::get("/testings", [TestController::class, "mainIndex"]);
    Route::get("/", [TestController::class, "index"]);
    Route::post("/", [TestController::class, "store"]);
    Route::get("/{id}", [TestController::class, "view"]);
    Route::patch("/{id}", [TestController::class, "update"]);
    Route::delete("/{id}", [TestController::class, "destroy"]);
});

Route::get('/tests/{id}/questions', [TestController::class, 'getTestQuestionsAndAnswers']);
Route::get('/test-schedule/{id}/check', [TestController::class, 'checkTestSchedule']);

Route::group(["namespace" => "Question", "prefix" => "questions"], function() {
    Route::get("/", [QuestionController::class, "index"]);
    Route::post("/", [QuestionController::class, "store"]);
    Route::get("/{id}", [QuestionController::class, "view"]);
    Route::patch("/{id}", [QuestionController::class, "update"]);
    Route::delete("/{id}", [QuestionController::class, "destroy"]);
});

Route::group(["namespace" => "TestSchedule", "prefix" => "testschedules"], function() {
    Route::get("/", [TestScheduleController::class, "index"]);
    Route::get("/res/{user_id}", [TestScheduleController::class, "results"]);
    Route::get("/group/{id}/{user_id}", [TestScheduleController::class, "viewGroup"]);
    Route::post("/", [TestScheduleController::class, "store"]);
    Route::get("/{id}", [TestScheduleController::class, "view"]);
    Route::patch("/{id}", [TestScheduleController::class, "update"]);
    Route::delete("/{id}", [TestScheduleController::class, "destroy"]);
});

Route::group(["namespace" => "Answer", "prefix" => "answers"], function() {
    Route::get("/", [AnswerController::class, "index"]);
    Route::post("/", [AnswerController::class, "store"]);
    Route::get("/{id}", [AnswerController::class, "view"]);
    Route::patch("/{id}", [AnswerController::class, "update"]);
    Route::delete("/{id}", [AnswerController::class, "destroy"]);
});

Route::group(["namespace" => "UserAnswer", "prefix" => "useranswer"], function() {
    Route::post("/end-quest", [UserAnswerController::class, "endQuest"]);
    
    Route::get("/", [UserAnswerController::class, "index"]);
    Route::post("/", [UserAnswerController::class, "store"]);
    Route::get("/{id}", [UserAnswerController::class, "view"]);
    Route::patch("/{id}", [UserAnswerController::class, "update"]);
    Route::delete("/{id}", [UserAnswerController::class, "destroy"]);
});