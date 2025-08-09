<?php

namespace App\Services\Ai;

interface AiClientInterface
{
    /**
     * Analyze survey payload and return normalized array result
     * [
     *   'top_majors' => [[ 'major_code' => 'SE', 'score' => 92 ]],
     *   'explanation_md' => '...'
     * ]
     */
    public function analyze(array $payload): array;
}


