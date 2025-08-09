<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SurveyQuestion extends Model
{
    protected $fillable = ['category','text','type','display_order'];

    public function options(): HasMany
    {
        return $this->hasMany(SurveyOption::class);
    }
}
