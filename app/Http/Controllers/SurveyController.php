<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Jobs\GenerateRecommendationJob;

class SurveyController extends Controller {
  public function index() { return view('survey.index'); }

  public function submit(Request $request) {
    $survey = Survey::create(['user_id'=>auth()->id(),'status'=>'submitted']);
    GenerateRecommendationJob::dispatch($survey->id);
    return redirect()->route('recommendations.show', $survey);
  }
}