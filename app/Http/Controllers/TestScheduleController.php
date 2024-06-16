<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\TestScheduleResource;
use App\Http\Requests\TestSchedule\StoreRequest;
use App\Models\TestSchedule;
use App\Http\Controllers\TestController;
use Carbon\Carbon;

use App\Models\User;
use App\Models\UserAnswer;
use App\Models\Answer;
use App\Models\Test;
use App\Models\Question;


class TestScheduleController extends Controller
{
    public function index() {
        return TestScheduleResource::collection(TestSchedule::all());
    }
    
    public function checkTestSchedule($testScheduleId) { // Проеверка теста на актуальность
        $testSchedule = TestSchedule::findOrFail($testScheduleId);
        $current_time = Carbon::now();
        if ($current_time->isAfter($testSchedule->end_time)) {
            return false;
            // return response()->json(['message' => 'The test has ended.'], 403);
        } return true;
        // return response()->json(['message' => 'The test is ongoing.']);
    }

    public function viewGroup($group_id, $user_id) {
        $testSchedules = TestSchedule::where('group_id', $group_id)->get();
        $newData = [];
    
        foreach ($testSchedules as $testSchedule) {
            // Получение всех вопросов для текущего теста
            $test = Test::find($testSchedule->test_id);
            $questions = $test->questions;
    
            // Проверка, есть ли ответы пользователя для этих вопросов
            $answeredQuestions = UserAnswer::where('user_id', $user_id)
                                            ->whereIn('question_id', $questions->pluck('id'))
                                            ->exists();
    
            // Если ответов нет, то добавляем тест в результат
            if (!$answeredQuestions) {
                $newData[] = $testSchedule;
            }
        }
    
        return TestScheduleResource::collection($newData);
    }

    // public function viewGroup($id, $user_id) {
    //     $user = User::where("id", $user_id)->first();
    //     $tests = TestSchedule::where("group_id", $id)->get();
    //     $newData = [];
    //     foreach ($tests as $test) {
    //         $res = $this->checkTestSchedule($test->id);
    //         // Добавление теста, если условие выполнено
    //         if ($res) {
    //             print($test);
    //             $newData[] = $test;
    //         }
    //     }
    
    //     return TestScheduleResource::collection($newData);
    // }

    public function results($user_id) {
            // Получаем все расписания тестов, в которых участвовал пользователь
            $user = User::find($user_id);
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
    
            // Получаем все ответы пользователя
            $userAnswers = UserAnswer::where('user_id', $user_id)->get();
    
            // Извлекаем уникальные question_id из ответов пользователя
            $questionIds = $userAnswers->pluck('question_id')->unique();
    
            // Получаем все уникальные test_id на основе question_id
            $testIds = Question::whereIn('id', $questionIds)->pluck('test_id')->unique();
    
            // Получаем все тесты, которые прошел пользователь
            $tests = Test::whereIn('id', $testIds)->get();
    
            $results = [];
    
            foreach ($tests as $test) {
                $questions = $test->questions;
    
                // Получаем ответы пользователя на вопросы этого теста
                $userAnswers = UserAnswer::where('user_id', $user_id)
                                        ->whereIn('question_id', $questions->pluck('id'))
                                        ->get();
    
                // Считаем суммарные points за все ответы пользователя на вопросы этого теста
                $totalPoints = $userAnswers->sum(function($userAnswer) {
                    return $userAnswer->answer ? $userAnswer->answer->points : 0;
                });
    
                $results[] = [
                    'test_id' => $test->id,
                    'test_title' => $test->title,
                    'total_points' => $totalPoints,
                ];
            }
    return response()->json($results);
    }
    
    public function resultsы($user_id) {
        $userData = UserAnswer::where("user_id", $user_id)->get();
        $resCount = 0;
        $length = 0;
        foreach($userData as $item) {
            $answerID = $item["answer_id"];
            $answerData = Answer::where("id", $answerID)->first();
            $resCount = $resCount + $answerData["points"];
            $length += 1;
        }
        return response()->json([
            "results" => $resCount,
            "length" => $length,
        ]);
        // $answers = Answer::where("id", )
    }   

    public function view($id) {
        return new TestScheduleResource(TestSchedule::findOrFail($id));
    }

    public function store(StoreRequest $req) {
        $valData = $req->validated();
        $data = TestSchedule::create($valData);
        return response()->json($data);
    }

    public function update($id, StoreRequest $req) {
        $data = TestSchedule::find($id);
        if (!$data) 
            return response()->json(['message' => 'Не найдено'], 404);
        $valData = $req->validated();
        $data->update($valData);
        return response()->json($data);
    }

    public function destroy($id) {
        $data = TestSchedule::find($id);
        if (!$data) 
            return response()->json(['message' => 'Не найдено'], 404);
        $data->delete();
        return response()->json($data);
    }
}
