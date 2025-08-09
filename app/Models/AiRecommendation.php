<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiRecommendation extends Model
{
    protected $fillable = [
        'survey_id','model','prompt_hash','ai_raw_json','top_major_ids_json','explanation_md','score_breakdown_json'
    ];

    protected $casts = [
        'ai_raw_json' => 'array',
        'top_major_ids_json' => 'array',
        'score_breakdown_json' => 'array',
    ];

    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }
}
