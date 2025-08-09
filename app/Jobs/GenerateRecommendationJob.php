<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Survey;
use App\Models\AiRecommendation;
use App\Services\Ai\AiAnalysisService;

class GenerateRecommendationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $surveyId)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(AiAnalysisService $service): void
    {
        $survey = Survey::with(['scores','responses'])->find($this->surveyId);
        if (!$survey) return;

        $result = $service->generateForSurvey($survey);
        if (!is_array($result)) return;
        AiRecommendation::updateOrCreate(
            ['survey_id' => $survey->id],
            [
                'model' => config('ai.openrouter.model'),
                'prompt_hash' => hash('sha256', json_encode($result)),
                'ai_raw_json' => $result,
                'top_major_ids_json' => $result['top_majors'] ?? [],
                'explanation_md' => $result['explanation_md'] ?? null,
                'score_breakdown_json' => $result['score_breakdown'] ?? null,
            ]
        );
    }
}
