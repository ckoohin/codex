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

  public function simple() {
    return view('survey.simple');
  }

  public function submit(Request $request) {
    // Hỗ trợ 2 kiểu payload: dạng responses[] và các trường select đơn giản
    // Hỗ trợ tên trường 'like' từ form đơn giản (map sang interests)
    if ($request->filled('like') && !$request->filled('interests')) {
      $request->merge(['interests' => $request->input('like')]);
    }

    $validated = $request->validate([
      'scores' => ['sometimes','array'],
      'responses' => ['sometimes','array'],
      'interests' => ['sometimes','string','max:255'],
      'skills' => ['sometimes','string','max:255'],
      'subject' => ['sometimes','string','max:255'],
      'career' => ['sometimes','string','max:255'],
      'techLove' => ['sometimes','string','max:255'],
      'creativity' => ['sometimes','string','max:255'],
    ]);
    $survey = Survey::create(['user_id'=>auth()->id(),'status'=>'submitted']);
    foreach (($validated['scores'] ?? []) as $subjectId => $score) {
      $survey->scores()->updateOrCreate(['subject_id'=>$subjectId],[ 'score_decimal'=>$score ]);
    }
    if (!empty($validated['responses'])) {
      foreach ($validated['responses'] as $questionId => $answer) {
        $survey->responses()->updateOrCreate(['survey_question_id'=>$questionId],[ 'answer_json'=>$answer ]);
      }
    }

    // Map các trường đơn giản thành câu hỏi nếu được gửi từ form mới
    $simpleFields = [
      'interests' => ['category' => 'interests', 'text' => 'Sở thích'],
      'skills' => ['category' => 'skills', 'text' => 'Kỹ năng nổi bật'],
      'subject' => ['category' => 'interests', 'text' => 'Môn học yêu thích'],
      'career' => ['category' => 'career', 'text' => 'Định hướng nghề nghiệp'],
      'techLove' => ['category' => 'traits', 'text' => 'Mức độ yêu thích công nghệ'],
      'creativity' => ['category' => 'traits', 'text' => 'Mức độ sáng tạo'],
    ];
    $order = 1;
    foreach ($simpleFields as $field => $meta) {
      $value = $request->input($field);
      if ($value === null || $value === '') { continue; }
      $question = SurveyQuestion::firstOrCreate(
        ['category' => $meta['category'], 'text' => $meta['text']],
        ['type' => 'single', 'display_order' => $order++]
      );
      $survey->responses()->updateOrCreate(
        ['survey_question_id' => $question->id],
        ['answer_json' => $value]
      );
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

    // Lưu nháp cho các trường đơn giản
    $simpleFields = [
      'interests' => ['category' => 'interests', 'text' => 'Sở thích'],
      'skills' => ['category' => 'skills', 'text' => 'Kỹ năng nổi bật'],
      'subject' => ['category' => 'interests', 'text' => 'Môn học yêu thích'],
      'career' => ['category' => 'career', 'text' => 'Định hướng nghề nghiệp'],
      'techLove' => ['category' => 'traits', 'text' => 'Mức độ yêu thích công nghệ'],
      'creativity' => ['category' => 'traits', 'text' => 'Mức độ sáng tạo'],
    ];
    $order = 1;
    foreach ($simpleFields as $field => $meta) {
      $value = $request->input($field);
      if ($value === null || $value === '') { continue; }
      $question = SurveyQuestion::firstOrCreate(
        ['category' => $meta['category'], 'text' => $meta['text']],
        ['type' => 'single', 'display_order' => $order++]
      );
      $survey->responses()->updateOrCreate(
        ['survey_question_id' => $question->id],
        ['answer_json' => $value]
      );
    }

    return response()->json(['success' => true, 'survey_id' => $survey->id]);
  }
}