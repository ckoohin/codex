<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Subject;
use App\Models\SurveyQuestion;
use App\Jobs\GenerateRecommendationJob;
use Illuminate\Support\Facades\Http;

use function Psy\debug;

class SurveyController extends Controller {
  public function index() {
    // $subjects = Subject::orderBy('name')->get(['id','name']);
    // $questions = SurveyQuestion::orderBy('display_order')->get(['id','category','text','type']);
    return view('survey.index');
  }

  

  public function handleInfo() {
      
      $likeContent = $_POST['like'];
      $skillsContent = $_POST['skills'];
      $subjectContent = $_POST['subject'];
      $careerContent = $_POST['career'];
      $techLoveRContent = $_POST['techLove'];
      $creativityContent = $_POST['creativity'];

      $listMajor = '';

      $majors = Http::withHeaders([
          'Accept' => 'application/json',
      ])->get('http://localhost:3000/majors');

      $data = $majors->json();

      foreach ($data as $value) {
          $listMajor=  $listMajor .", {$value['name']}";
      }



      // dd($listMajor);



      $promt = "Gợi ý ngành học thông qua các trường sau $likeContent $skillsContent $subjectContent $careerContent $techLoveRContent$creativityContent. Chỉ cần trả về 1 ngành học duy nhất trong các ngành sau $listMajor";

      $response = Http::withHeaders([
        'Authorization' => 'Bearer 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',
        'Content-Type' => 'application/json',
    ])->post('https://openrouter.ai/api/v1/chat/completions', [
        'model' => 'deepseek/deepseek-chat-v3-0324:free',
        'messages' => [
            ['role' => 'system', 'content' => 'You are a helpful assistant.'],
            ['role' => 'user', 'content' => $promt],
        ],
    ]);

    dd($response->json());


//     dd([
//     'status' => $response->status(),
//     'body' => $response->body(),
//     'json' => $response->json()
// ]);

    // return $response->json();
  }

  // public function submit(Request $request) {
  //   $validated = $request->validate([
  //     'scores' => ['required','array'],
  //     'responses' => ['required','array'],
  //   ]);
  //   $survey = Survey::create(['user_id'=>auth()->id(),'status'=>'submitted']);
  //   // Lưu điểm
  //   foreach ($validated['scores'] as $subjectId => $score) {
  //     $survey->scores()->updateOrCreate(['subject_id'=>$subjectId],[ 'score_decimal'=>$score ]);
  //   }
  //   // Lưu câu trả lời
  //   foreach ($validated['responses'] as $questionId => $answer) {
  //     $survey->responses()->updateOrCreate(['survey_question_id'=>$questionId],[ 'answer_json'=>$answer ]);
  //   }
  //   GenerateRecommendationJob::dispatch($survey->id);
  //   return response()->json(['redirect'=>route('recommendations.show',$survey)]);
  // }
}