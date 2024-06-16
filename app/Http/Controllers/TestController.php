<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\TestResource;
use App\Http\Requests\Test\StoreRequest;
use App\Models\Test;

use Carbon\Carbon;

use App\Models\Discipline;
use App\Models\Author;
use App\Models\TestSchedule;

use App\Models\Question;
use App\Models\Answer;

// Article::create(['title' => 'Traveling to Europe']);

class TestController extends Controller
{

    public function getTestQuestionsAndAnswers($testId) { // Получение теста со всеми вопросами 
        $test = Test::with(['questions.answers'])->findOrFail($testId);
        return response()->json($test);
    }

    public function checkTestSchedule($testScheduleId) { // Проеверка теста на актуальность
        $testSchedule = TestSchedule::findOrFail($testScheduleId);
        $current_time = Carbon::now();
        if ($current_time->isAfter($testSchedule->end_time)) {
            return response()->json(['message' => 'The test has ended.'], 403);
        }
        return response()->json(['message' => 'The test is ongoing.']);
    }

    public function setTestQuestionsAndAnwsers(Request $request) { // Функция добавления теста
        $data = $request->json()->all();
        $testID = null;
        $questionID = null;
        foreach ($data as $item) {
            if (isset($item["tests"])) { // Создание теста
                $test = $item["tests"];
                $createTest = Test::create($test);
                $testID =$createTest["id"]; // Тестирование
                continue;
            }

            $questions = $item['questions'];
            $text = $questions['text'];
            $createQuestion = Question::create([
                "text" => $text, "test_id" => $testID,
            ]);
            $questionID = $createQuestion["id"];

            $answers = $item['answers'];
            foreach ($answers as $answer) {
                $text = $answer['text'];
                $points = $answer['points'];
                $createAnswer = Answer::create([
                    "question_id" => $questionID,
                    "text" => $text,
                    "points" => $points,
                ]);
            }
        }
        return $this->getTestQuestionsAndAnswers($testID);
    }

    public function index() {
        // return TestSchedule::get();
        return TestResource::collection(Test::all());
    }
    
    public function viewGroup($group) {
        return new TestResource(Test::where("group_id"));
    }

    public function view($id) {
        return new TestResource(Test::findOrFail($id));
    }

    public function store(StoreRequest $req) {
        $valData = $req->validated();
        $data = Test::create($valData);
        return response()->json($data);
    }

    public function update($id, StoreRequest $req) {
        $data = Test::find($id);
        if (!$data) 
            return response()->json(['message' => 'Не найдено'], 404);
        $valData = $req->validated();
        $data->update($valData);
        return response()->json($data);
    }

    public function destroy($id) {
        $data = Test::find($id);
        if (!$data) 
            return response()->json(['message' => 'Не найдено'], 404);
        $data->delete();
        return response()->json($data);
    }
}
