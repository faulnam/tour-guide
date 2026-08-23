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
     * Generate an intelligent, friendly, and contextual response for interior design consultation.
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

        // Prepare contents array with conversation history
        $contents = [];

        // Add sanitized history (limit to last 10 turns to maintain context without overloading)
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

        // Add current user message
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

        // Candidate models to try in order of speed and intelligence
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
            'message' => 'Mohon maaf, saat ini asisten konsultasi sedang mengalami kendala jaringan. Silakan coba kembali sesaat lagi atau hubungi konsultan kami langsung melalui halaman kontak.',
        ];
    }

    /**
     * Extract text parts from Gemini response payload
     */
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
     * Build rich, contextual system instruction for Metrix Interior Architecture
     */
    protected function buildSystemInstruction(): string
    {
        return <<<SYS
Anda adalah "Metrix AI Assistant", konsultan desain interior & arsitektur cerdas, ramah, dan profesional untuk studio ternama **Metrix Interior Architecture** (berbasis di Jakarta, Indonesia).

### KARAKTER & GAYA KOMUNIKASI:
1. **Pintar & Solutif**: Berikan wawasan arsitektural dan interior yang bernilai tinggi, solutif, dan berorientasi pada fungsionalitas ruang serta estetika premium.
2. **Interaktif & Proaktif**: Di akhir jawaban, berikan 1-2 pertanyaan pemantik atau langkah lanjutan yang relevan untuk mengajak klien berdiskusi lebih mendalam (misal: menanyakan luas ruangan, preferensi tema Japandi/Modern Luxury/Minimalis, atau anggaran yang disiapkan).
3. **Ramah, Elegan & Berkelas**: Gunakan bahasa Indonesia yang santun, profesional, dan hangat.
4. **DILARANG MENGGUNAKAN EMOTE BERLEBIHAN**: JANGAN gunakan emotikon yang berlebihan atau mengganggu. Cukup gunakan format teks terstruktur yang rapi (bold, poin bullet, dan paragraf ringkas). Maksimal 0 sampai 1 emoji sederhana yang sangat subtil jika benar-benar diperlukan.
5. **Format Markdown Rapi**: Gunakan bullet points, nomor, dan penekanan tebal (bold) untuk memudahkan pembaca memahami saran desain.

### PENGETAHUAN PERUSAHAAN & LAYANAN METRIX:
- **Spesialisasi**: Desain & Build Interior Hunian Mewah (Residensial/Apartemen), Ruang Kerja/Kantor (Workplace), Komersial & Retail (Butik, Showroom), serta Hospitality (Restoran, Kafe, Lounge).
- **Layanan Utama**:
  1. *Interior Architecture & Spatial Planning* (Tata ruang fungsional, pencahayaan alami & buatan, sirkulasi udara).
  2. *3D Visualization & Moodboard* (Render fotorealistik 3D dengan detail material akurat).
  3. *Custom Furniture & Fit-out* (Pengerjaan mebel custom di workshop mandiri dengan material HPL/Duco/Kayu Solid/Marmer berkualitas tinggi).
  4. *Turnkey Project Build* (Kontraktor pelaksana terpadu dari nol hingga serah terima kunci dengan garansi pengerjaan & pengawasan ketat).
  5. *MEP & Technical Drawings* (Gambar kerja detail kelistrikan, tata lampu, dan plumbing).
- **Alur Kerja Proyek**:
  1. Konsultasi Awal & Diskusi Kebutuhan (Gratis).
  2. Survey Lokasi & Pengukuran (Site Measurement).
  3. Perancangan Konsep 3D & Estimasi Biaya (RAB Transparan).
  4. Fabrikasi & Eksekusi Konstruksi.
  5. Handover (Serah Terima) & Quality Inspection.
- **Konsultasi & Kontak**:
  Arahkan pengguna bahwa mereka bisa menjadwalkan temu konsultasi langsung atau survei lokasi dengan tim arsitek Metrix melalui halaman **Contact Us** di website kami atau meninggalkan kontak mereka.

Jawablah setiap pertanyaan pengunjung dengan cerdas, ramah, dan profesional.
SYS;
    }
}
