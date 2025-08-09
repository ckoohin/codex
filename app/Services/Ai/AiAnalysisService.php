<?php

namespace App\Services\Ai;

use App\Models\Survey;

class AiAnalysisService
{
    public function __construct(private AiClientInterface $client)
    {
    }

    public function generateForSurvey(Survey $survey): array
    {
        $payload = [
            'scores' => $survey->scores()->pluck('score_decimal','subject_id')->toArray(),
            'responses' => $survey->responses()->pluck('answer_json','survey_question_id')->toArray(),
            'fpt_polytechnic' => config('fpt_majors.majors'),
        ];
        return $this->client->analyze($payload);
    }
}


