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
      'scores' => ['sometimes','array'],
      'responses' => ['required','array'],
    ]);
    $survey = Survey::create(['user_id'=>auth()->id(),'status'=>'submitted']);
    foreach (($validated['scores'] ?? []) as $subjectId => $score) {
      $survey->scores()->updateOrCreate(['subject_id'=>$subjectId],[ 'score_decimal'=>$score ]);
    }
    foreach ($validated['responses'] as $questionId => $answer) {
      $survey->responses()->updateOrCreate(['survey_question_id'=>$questionId],[ 'answer_json'=>$answer ]);
    }
    GenerateRecommendationJob::dispatch($survey->id);
    return redirect()->route('recommendations.show', $survey);
  }

  public function draft(Request $request) {
    $scores = $request->input('scores', []);
    $responses = $request->input('responses', []);

    $survey = Survey::firstOrCreate([
      'user_id' => auth()->id(),
      'status' => 'draft',
    ]);

    foreach ($scores as $subjectId => $score) {
      if ($score === '' || $score === null) { continue; }
      $survey->scores()->updateOrCreate(['subject_id' => $subjectId], [
        'score_decimal' => $score,
      ]);
    }
    foreach ($responses as $questionId => $answer) {
      if ($answer === '' || $answer === null) { continue; }
      $survey->responses()->updateOrCreate(['survey_question_id' => $questionId], [
        'answer_json' => $answer,
      ]);
    }

    return response()->json(['success' => true, 'survey_id' => $survey->id]);
  }
}