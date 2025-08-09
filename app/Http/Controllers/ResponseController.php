<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\SurveyResponse;
use App\Models\Score;

class ResponseController extends Controller
{
    public function storeResponses(Request $request)
    {
        $validated = $request->validate([
            'survey_id' => ['required','integer','exists:surveys,id'],
            'responses' => ['required','array'],
            'responses.*.survey_question_id' => ['required','integer'],
            'responses.*.answer' => ['required'],
        ]);

        $survey = Survey::findOrFail($validated['survey_id']);
        foreach ($validated['responses'] as $item) {
            SurveyResponse::updateOrCreate(
                [
                    'survey_id' => $survey->id,
                    'survey_question_id' => $item['survey_question_id'],
                ],
                [ 'answer_json' => $item['answer'] ]
            );
        }
        return response()->json(['ok' => true]);
    }

    public function storeScores(Request $request)
    {
        $validated = $request->validate([
            'survey_id' => ['required','integer','exists:surveys,id'],
            'scores' => ['required','array'],
            'scores.*.subject_id' => ['required','integer'],
            'scores.*.score_decimal' => ['required','numeric','between:0,10'],
        ]);

        foreach ($validated['scores'] as $s) {
            Score::updateOrCreate(
                [
                    'survey_id' => $validated['survey_id'],
                    'subject_id' => $s['subject_id'],
                ],
                [ 'score_decimal' => $s['score_decimal'] ]
            );
        }
        return response()->json(['ok' => true]);
    }
}
