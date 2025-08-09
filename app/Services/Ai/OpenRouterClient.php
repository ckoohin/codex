<?php

namespace App\Services\Ai;

use Illuminate\Support\Facades\Http;

class OpenRouterClient implements AiClientInterface
{
    public function analyze(array $payload): array
    {
        $baseUrl = config('ai.openrouter.base_url');
        $apiKey = config('ai.openrouter.api_key');
        $model = config('ai.openrouter.model');

        $system = <<<EOT
        Bạn là cố vấn hướng nghiệp của FPT Polytechnic.
        - Bạn nhận được dữ liệu khảo sát của một sinh viên và DANH MỤC NGÀNH từ CSDL của trường (majors_catalog: gồm code, name, skills/tags).
        - Nhiệm vụ: so khớp sở thích/kỹ năng/mục tiêu trong payload với danh mục ngành để chấm điểm mức độ phù hợp.
        - ƯU TIÊN CHỌN ngành có trong majors_catalog. Không bịa mã ngành mới.
        - Nếu không đủ dữ liệu, vẫn phải trả về ít nhất 2 ngành phù hợp nhất từ majors_catalog với score thấp hơn.

        JSON OUTPUT BẮT BUỘC (không thêm chữ):
        {
          "top_majors": [ {"major_code": "TKDH", "score": 0-100}, ... ],
          "explanation_md": "Markdown ngắn gọn giải thích vì sao phù hợp và gợi ý học những kỹ năng/HP đầu tiên",
          "score_breakdown": {"TKDH": {"skills_fit":0-100,"interests_fit":0-100}}
        }
        EOT;

        $user = [ 'payload' => $payload ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$apiKey,
                'HTTP-Referer' => config('ai.openrouter.site_url'),
                'X-Title' => config('ai.openrouter.app_name'),
            ])->post($baseUrl.'/chat/completions', [
                'model' => $model,
                'messages' => [
                    ['role' => 'system', 'content' => $system],
                    ['role' => 'user', 'content' => json_encode($user, JSON_UNESCAPED_UNICODE)],
                ],
                'response_format' => [ 'type' => 'json_object' ],
                'temperature' => 0.2,
            ]);

            if (!$response->ok()) {
                \Log::warning('OpenRouter error', ['status'=>$response->status(),'body'=>$response->body()]);
                return ['top_majors' => [], 'explanation_md' => ''];
            }

            $data = $response->json();
            $content = $data['choices'][0]['message']['content'] ?? '{}';
            $parsed = json_decode($content, true);
            if (!is_array($parsed)) {
                \Log::warning('OpenRouter parse failed', ['content'=>$content]);
                return ['top_majors' => [], 'explanation_md' => ''];
            }
            return $parsed;
        } catch (\Throwable $e) {
            \Log::error('OpenRouter exception', ['error'=>$e->getMessage()]);
            return ['top_majors' => [], 'explanation_md' => ''];
        }
    }
}


