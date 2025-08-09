<?php

namespace App\Services\Ai;

use App\Models\Survey;
use App\Models\Major;

class AiAnalysisService
{
    public function __construct(private AiClientInterface $client)
    {
    }

    public function generateForSurvey(Survey $survey): array
    {
        // Lấy danh mục ngành từ DB (ưu tiên) – gồm code, name, skills (tags)
        $majors = Major::where('is_active', true)
            ->get()
            ->map(fn($m) => [
                'code' => $m->code,
                'name' => $m->name,
                'skills' => $m->tags ?? [],
            ])->values()->all();
        if (empty($majors)) {
            $majors = array_map(function($m){
                return [
                    'code' => $m['code'],
                    'name' => $m['name'],
                    'skills' => $m['skills'] ?? [],
                ];
            }, config('fpt_majors.majors'));
        }

        $payload = [
            'scores' => $survey->scores()->pluck('score_decimal','subject_id')->toArray(),
            'responses' => $survey->responses()->pluck('answer_json','survey_question_id')->toArray(),
            'majors_catalog' => $majors,
            'allowed_codes' => array_values(array_map(fn($m) => $m['code'], $majors)),
        ];
        return $this->client->analyze($payload);
    }
}


