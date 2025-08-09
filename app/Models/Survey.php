<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Survey extends Model
{
    protected $fillable = ['user_id','status'];

    public function responses(): HasMany
    {
        return $this->hasMany(SurveyResponse::class);
    }

    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }

    public function aiRecommendation(): HasOne
    {
        return $this->hasOne(AiRecommendation::class);
    }
}
