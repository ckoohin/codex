<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Score extends Model
{
    protected $fillable = ['survey_id','subject_id','score_decimal'];

    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }
}
