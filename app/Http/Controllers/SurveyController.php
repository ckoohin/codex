<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Subject;
use App\Models\SurveyQuestion;
use App\Jobs\GenerateRecommendationJob;

class SurveyController extends Controller {
  public function index() {
    $subjects = Subject::orderBy('name')->get(['id','name']);
    $questions = SurveyQuestion::orderBy('display_order')->get(['id','category','text','type']);
    return view('survey.index', compact('subjects','questions'));
  }

  public function submit(Request $request) {
    $validated = $request->validate([
      'scores' => ['required','array'],
      'responses' => ['required','array'],
    ]);
    $survey = Survey::create(['user_id'=>auth()->id(),'status'=>'submitted']);
    // Lưu điểm
    foreach ($validated['scores'] as $subjectId => $score) {
      $survey->scores()->updateOrCreate(['subject_id'=>$subjectId],[ 'score_decimal'=>$score ]);
    }
    // Lưu câu trả lời
    foreach ($validated['responses'] as $questionId => $answer) {
      $survey->responses()->updateOrCreate(['survey_question_id'=>$questionId],[ 'answer_json'=>$answer ]);
    }
    GenerateRecommendationJob::dispatch($survey->id);
    return response()->json(['redirect'=>route('recommendations.show',$survey)]);
  }
}