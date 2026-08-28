<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected string $apiKey;
    protected string $defaultModel;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key') ?? env('GEMINI_API_KEY', '');
        $this->defaultModel = config('services.gemini.model') ?? env('GEMINI_MODEL', 'gemini-3.6-flash');
    }

    /**
     * Generate an intelligent, friendly, and contextual response for automotive & modification consultation.
     */
    public function generateChatReply(string $userMessage, array $conversationHistory = []): array
    {
        if (empty($this->apiKey)) {
            return [
                'success' => false,
                'message' => 'API Key Gemini belum dikonfigurasi pada server.',
            ];
        }

        $systemInstructionText = $this->buildSystemInstruction();

        $contents = [];
        $recentHistory = array_slice($conversationHistory, -10);
        foreach ($recentHistory as $turn) {
            $role = ($turn['role'] ?? 'user') === 'user' ? 'user' : 'model';
            $text = trim($turn['text'] ?? ($turn['content'] ?? ''));
            if (!empty($text)) {
                $contents[] = [
                    'role' => $role,
                    'parts' => [
                        ['text' => $text]
                    ]
                ];
            }
        }

        $contents[] = [
            'role' => 'user',
            'parts' => [
                ['text' => $userMessage]
            ]
        ];

        $payload = [
            'systemInstruction' => [
                'parts' => [
                    ['text' => $systemInstructionText]
                ]
            ],
            'contents' => $contents,
            'generationConfig' => [
                'temperature' => 0.7,
                'topP' => 0.95,
                'maxOutputTokens' => 2048,
            ]
        ];

        $modelsToTry = array_unique([
            $this->defaultModel,
            'gemini-3.5-flash-lite',
            'gemini-flash-latest',
            'gemini-3.5-flash',
            'gemini-3.1-flash-lite',
            'gemini-3.6-flash'
        ]);

        foreach ($modelsToTry as $model) {
            try {
                $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$this->apiKey}";

                $response = Http::withoutVerifying()
                    ->timeout(18)
                    ->withHeaders(['Content-Type' => 'application/json'])
                    ->post($url, $payload);

                if ($response->successful()) {
                    $data = $response->json();
                    $replyText = $this->extractCandidateText($data);

                    if (!empty($replyText)) {
                        return [
                            'success' => true,
                            'reply' => $replyText,
                            'model' => $model,
                        ];
                    }
                }

                Log::warning("Gemini API attempt failed with model {$model}: " . $response->status() . " - " . $response->body());
            } catch (\Throwable $e) {
                Log::error("Gemini API exception with model {$model}: " . $e->getMessage());
            }
        }

        return [
            'success' => false,
            'message' => 'Mohon maaf, asisten modifikasi sedang sibuk. Silakan coba kembali sesaat lagi atau hubungi admin bengkel kami.',
        ];
    }

    protected function extractCandidateText(array $data): string
    {
        $parts = $data['candidates'][0]['content']['parts'] ?? [];
        $textOutput = '';

        foreach ($parts as $part) {
            if (isset($part['text'])) {
                $textOutput .= $part['text'];
            }
        }

        return trim($textOutput);
    }

    /**
     * Build rich, contextual system instruction for BENGKEL Workshop & Custom Tuning
     */
    protected function buildSystemInstruction(): string
    {
        $companyName = \App\Models\SiteSetting::get('company_name', 'BENGKEL');
        return <<<SYS
Anda adalah "{$companyName} AI Tuning & Workshop Consultant", asisten cerdas dan pakar modifikasi otomotif untuk **{$companyName}** (Workshop Modifikasi Motor & Mobil Terkemuka di Jakarta).

### KARAKTER & PENGETAHUAN OTOMOTIF:
1. **Pakar Modifikasi Motor & Mobil**: Sangat memahami detail teknis mesin (ECU Remap, dyno tuning, turbocharger, porting polish), kustomisasi motor (Cafe Racer, Bobber, Scrambler, Chopper), eksterior mobil (Widebody kit, carbon fiber aero, cat oven Spies Hecker), kaki-kaki (Air suspension, Big Brake Kit, coilover), serta perawatan servis berkala & detailing 9H.
2. **Solutif & Informatif**: Berikan estimasi peningkatan tenaga (HP/Torsi), rekomendasi suku cadang terbaik (Brembo, Akrapovic, Ohlins, HKS, BBS), serta tips perawatan mesin modifikasi.
3. **Arahkan ke Booking & Konsultasi**: Sarankan pengguna untuk melakukan **Booking Online** melalui website {$companyName} atau berkonsultasi langsung dengan tim Lead Tuner kami di workshop.
4. **Bahasa**: Bahasa Indonesia yang santun, profesional, antusias terhadap dunia modifikasi (petrolhead & biker friendly).
5. **Format Markdown Rapi**: Gunakan bullet point dan teks tebal untuk keterbacaan yang maksimal.

Jawablah pertanyaan pengguna dengan presisi dan antusiasme tinggi!
SYS;
    }
}
