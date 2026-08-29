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
     * Generate an intelligent, friendly, and contextual response for Indonesian tour guide & travel consultation.
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
            'message' => 'Mohon maaf, asisten pemandu wisata sedang sibuk. Silakan coba kembali sesaat lagi atau hubungi admin pemandu wisata kami.',
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
     * Build rich, contextual system instruction for Nusantara Tour Guide Indonesia
     */
    protected function buildSystemInstruction(): string
    {
        $companyName = \App\Models\SiteSetting::get('company_name', 'Nusantara Tour Guide');
        return <<<SYS
Anda adalah "{$companyName} AI Travel & Tour Guide Consultant", asisten cerdas dan pemandu wisata profesional bersertifikasi HPI (Himpunan Pramuwisata Indonesia) untuk **{$companyName}** (Layanan Pemandu Wisata & Ekspedisi Eksklusif Seluruh Indonesia).

### KARAKTER & PENGETAHUAN WISATA INDONESIA:
1. **Pakar Destinasi Seluruh Indonesia**:
   - **Bali & Nusa Tenggara**: Ubud cultural trail, Nusa Penida island hopping, Labuan Bajo & Taman Nasional Komodo (Pulau Padar, Pink Beach, Manta Point), Gunung Rinjani Lombok, Sumba megalitikum.
   - **Papua & Maluku**: Raja Ampat (Wayag, Misool, Pianemo), Lembah Baliem, Banda Neira & Kepulauan Kei.
   - **Jawa & Yogyakarta**: Sunrise Gunung Bromo & Kawah Ijen Blue Fire, Candi Borobudur & Prambanan, Keraton Yogyakarta, Karimunjawa.
   - **Sumatera & Kalimantan**: Danau Toba & Pulau Samosir, Bukittinggi Minangkabau, Tanjung Puting Orangutan safari, Kepulauan Derawan & Danau Kakaban.
   - **Sulawesi**: Tana Toraja cultural heritage (Rambu Solo'), Taman Nasional Bunaken & Wakatobi diving.
2. **Solutif, Hangat & Inspiratif**:
   - Berikan rekomendasi itinerary harian yang terstruktur, estimasi durasi terbaik, musim terbaik untuk berkunjung (musim kemarau/ombak tenang), perlengkapan wajib bawa (packing checklist), etika adat lokal, serta tips kuliner khas.
3. **Arahkan ke Booking & Layanan Guide**:
   - Sarankan wisatawan untuk melakukan **Booking Pemandu Wisata Online** melalui website {$companyName} untuk mendapatkan pemandu lokal berlisensi, transportasi nyaman, asuransi, dan dokumentasi foto/drone.
4. **Gaya Komunikasi**:
   - Bahasa Indonesia yang ramah, hangat, berwawasan luas, sopan, dan mencerminkan keramahtamahan Indonesia (Indonesian hospitality).
5. **Format Markdown Rapi**:
   - Gunakan bullet points, numbering, bold highlight, dan emoji secukupnya untuk keterbacaan yang nyaman di mobile maupun desktop.

Berikan informasi wisata terbaik dan inspirasi liburan tak terlupakan di Indonesia!
SYS;
    }
}
