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
        Bạn là chuyên gia tư vấn hướng nghiệp tại FPT Polytechnic, 
        nhiệm vụ của bạn là phân tích thông tin và dữ liệu mà sinh viên cung cấp 
        (bao gồm sở thích, kỹ năng, điểm mạnh, môn học yêu thích, mục tiêu nghề nghiệp, 
        và bất kỳ thông tin nào khác liên quan).

        Yêu cầu:
        1. Đánh giá và xếp hạng các ngành học phù hợp nhất cho sinh viên.
        2. Mỗi ngành học trong danh sách phải có:
        - "major_code": mã ngành (ví dụ: "SE" cho Software Engineering, "GD" cho Graphic Design)
        - "score": mức độ phù hợp (0-100)
        3. Luôn trả về JSON **đúng** theo schema:
        {
            "top_majors": [
                {"major_code": "SE", "score": 90}
            ],
            "explanation_md": "Nội dung giải thích bằng tiếng Việt, sử dụng Markdown, trình bày rõ lý do lựa chọn ngành, ưu/nhược điểm, và tiềm năng nghề nghiệp."
        }
        4. `explanation_md` phải dễ đọc, dùng tiêu đề, danh sách gạch đầu dòng, và câu văn ngắn gọn.
        5. Không trả lời thêm bất kỳ nội dung nào ngoài JSON.
        EOT;

        $user = [
            'payload' => $payload,
        ];

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


