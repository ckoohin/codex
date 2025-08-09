<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Major;

class RecommendationController extends Controller {
  public function show(Survey $survey) {
    $rec = $survey->aiRecommendation; // có thể chưa xong → hiển thị spinner
    $topMajors = [];
    if ($rec && is_array($rec->ai_raw_json)) {
      $list = $rec->ai_raw_json['top_majors'] ?? [];
      $codes = array_values(array_filter(array_map(fn($m)=>$m['major_code'] ?? null, $list)));
      if ($codes) {
        $map = Major::whereIn('code', $codes)->get()->keyBy('code');
        foreach ($list as $m) {
          $code = $m['major_code'] ?? '';
          $score = $m['score'] ?? null;
          $major = $map[$code] ?? null;
          $topMajors[] = [
            'code' => $code,
            'name' => $major?->name ?? $code,
            'score' => $score,
          ];
        }
      }
    }
    return view('recommendations.show', compact('survey','rec','topMajors'));
  }
}