<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class RecommendationController extends Controller {
  public function show(Survey $survey) {
    $rec = $survey->aiRecommendation; // có thể chưa xong → hiển thị spinner
    return view('recommendations.show', compact('survey','rec'));
  }
}