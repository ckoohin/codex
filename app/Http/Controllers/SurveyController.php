<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class SurveyController extends Controller {
  public function index() { return view('survey.index'); }
  public function submit(StoreSurveyResponseRequest $req) {
    $survey = Survey::create(['user_id'=>auth()->id(),'status'=>'submitted']);
    // lưu responses/scores đã tạm lưu từ session/local storage nếu cần
    GenerateRecommendationJob::dispatch($survey->id);
    return redirect()->route('recommendations.show', $survey);
  }
}