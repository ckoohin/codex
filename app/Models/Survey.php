<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'email', 
        'age',
        'gender',
        'grade',
        'scores',
        'interests', 
        'skills',
        'habits',
        'career',
        'status',
        'ai_analysis',
        'recommended_majors'
    ];

    protected $casts = [
        'scores' => 'array',
        'interests' => 'array',
        'skills' => 'array', 
        'habits' => 'array',
        'career' => 'array',
        'ai_analysis' => 'array',
        'recommended_majors' => 'array'
    ];

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeDraft($query) 
    {
        return $query->where('status', 'draft');
    }

    public function scopeByEmail($query, $email)
    {
        return $query->where('email', $email);
    }

    // Accessors
    public function getAverageScoreAttribute()
    {
        if (!$this->scores || empty($this->scores)) {
            return null;
        }
        
        $scores = array_filter($this->scores, function($score) {
            return $score !== null && $score !== '';
        });
        
        return empty($scores) ? null : round(array_sum($scores) / count($scores), 2);
    }

    public function getTopSubjectsAttribute()
    {
        if (!$this->scores || empty($this->scores)) {
            return [];
        }
        
        $scores = array_filter($this->scores, function($score) {
            return $score !== null && $score !== '' && $score >= 7;
        });
        
        arsort($scores);
        return array_slice($scores, 0, 3, true);
    }

    public function getTopSkillsAttribute()
    {
        if (!$this->skills || empty($this->skills)) {
            return [];
        }
        
        $skills = array_filter($this->skills, function($skill) {
            return $skill >= 7;
        });
        
        arsort($skills);
        return array_slice($skills, 0, 5, true);
    }

    // Mutators
    public function setScoresAttribute($value)
    {
        // Loại bỏ các giá trị null hoặc empty
        if (is_array($value)) {
            $value = array_filter($value, function($score) {
                return $score !== null && $score !== '';
            });
        }
        $this->attributes['scores'] = json_encode($value);
    }

    // Methods
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isDraft()
    {
        return $this->status === 'draft';
    }

    public function markAsCompleted()
    {
        $this->update(['status' => 'completed']);
        return $this;
    }

    public function calculateCompletionPercentage()
    {
        $totalFields = 7; // full_name, email, scores, interests, skills, habits, career
        $completedFields = 0;
        
        if ($this->full_name) $completedFields++;
        if ($this->email) $completedFields++;
        if ($this->scores && !empty($this->scores)) $completedFields++;
        if ($this->interests && !empty(array_filter($this->interests))) $completedFields++;
        if ($this->skills && !empty(array_filter($this->skills))) $completedFields++;
        if ($this->habits && !empty(array_filter($this->habits))) $completedFields++;
        if ($this->career && !empty(array_filter($this->career))) $completedFields++;
        
        return round(($completedFields / $totalFields) * 100);
    }

    public function hasRecommendations()
    {
        return !empty($this->recommended_majors);
    }

    // Relationships
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