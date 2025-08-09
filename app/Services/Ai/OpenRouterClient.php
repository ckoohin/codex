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
        $allowedCodes = $payload['allowed_codes'] ?? [];
        $allowedCodesStr = implode('", "', $allowedCodes);
        
        $system = <<<PROMPT
        Bạn là cố vấn hướng nghiệp cho sinh viên FPT Polytechnic.
        Chỉ sử dụng danh mục ngành trong payload (majors_catalog) và chỉ chọn mã trong allowed_codes: ["{$allowedCodesStr}"].
        Mục tiêu: TRẢ VỀ DUY NHẤT 1 NGÀNH PHÙ HỢP NHẤT.
        Quy tắc:
        - Nếu có dữ liệu phù hợp: trả về đúng 1 phần tử trong mảng top_majors (không quá 1).
        - Nếu không đủ dữ liệu: trả về mảng rỗng [] cho top_majors.
        - Không thêm thuyết minh dài dòng; đặt explanation_md là chuỗi rỗng "".
        - Không tạo mã ngành mới ngoài allowed_codes.

        JSON OUTPUT BẮT BUỘC (không thêm chữ):
        {
          "top_majors": [{"major_code": "<CODE>", "score": 0-100}],
          "explanation_md": ""
        }
        PROMPT;

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

            // Log dữ liệu gốc AI trả về
            \Log::info('AI raw response', [
                'data' => $data,
                'parsed_content' => $content,
                'payload_sent' => $payload
            ]);

            return json_decode($content, true) ?: ['top_majors' => [], 'explanation_md' => ''];

            // Filter to allowed_codes if provided
            if (!empty($payload['allowed_codes']) && !empty($parsed['top_majors'])) {
                $allowed = array_flip($payload['allowed_codes']);
                $parsed['top_majors'] = array_values(array_filter($parsed['top_majors'], function($m) use ($allowed){
                    return isset($allowed[$m['major_code'] ?? '']);
                }));
            }
            return $parsed;
        } catch (\Throwable $e) {
            \Log::error('OpenRouter exception', ['error'=>$e->getMessage()]);
            return ['top_majors' => [], 'explanation_md' => ''];
        }
    }
}


