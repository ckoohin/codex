<?php

return [
    'provider' => env('AI_PROVIDER', 'openrouter'),
    'openrouter' => [
        'api_key' => env('OPENAI_API_KEY'),
        'base_url' => env('OPENAI_BASE_URL', 'https://openrouter.ai/api/v1'),
        'model' => env('OPENAI_MODEL', 'google/gemini-2.0-flash-001'),
        'site_url' => env('OPENROUTER_SITE_URL', config('app.url')),
        'app_name' => env('OPENROUTER_APP_NAME', config('app.name')),
    ],
];


