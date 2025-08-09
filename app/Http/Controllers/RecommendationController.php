<?php

namespace App\Http\Controllers;

use App\Models\Survey;

class RecommendationController extends Controller {
  public function show(Survey $survey) {
    $rec = $survey->aiRecommendation; // có thể chưa xong → hiển thị spinner
    return view('recommendations.show', compact('survey','rec'));
  }
}