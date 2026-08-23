<?php

namespace App\Http\Controllers;

use App\Services\GeminiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class ChatbotController extends Controller
{
    protected GeminiService $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    /**
     * Handle incoming chat message from visitors
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:1500',
            'history' => 'nullable|array|max:20',
            'history.*.role' => 'required_with:history|string|in:user,model,assistant',
            'history.*.text' => 'required_with:history|string|max:2000',
        ]);

        $ip = $request->ip() ?? 'unknown';
        $key = 'chatbot-rate-limit:' . $ip;

        // Rate limiting: max 30 requests per minute per IP
        if (RateLimiter::tooManyAttempts($key, 30)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'success' => false,
                'message' => "Terlalu banyak permintaan. Silakan tunggu {$seconds} detik sebelum mengirim pesan baru.",
            ], 429);
        }

        RateLimiter::hit($key, 60);

        $userMessage = trim($request->input('message'));
        $history = $request->input('history', []);

        $result = $this->geminiService->generateChatReply($userMessage, $history);

        if (!$result['success']) {
            return response()->json($result, 500);
        }

        return response()->json([
            'success' => true,
            'reply' => $result['reply'],
            'model' => $result['model'] ?? 'gemini-3.6-flash',
        ]);
    }

    /**
     * Get initial quick suggestions
     */
    public function getSuggestions(): JsonResponse
    {
        return response()->json([
            'suggestions' => [
                [
                    'label' => 'Tahapan & Alur Proyek',
                    'prompt' => 'Bagaimana tahapan konsultasi dan alur pengerjaan proyek interior di Metrix?',
                ],
                [
                    'label' => 'Konsep Desain Ruang Tamu',
                    'prompt' => 'Apa rekomendasi konsep desain interior untuk ruang tamu modern Japandi?',
                ],
                [
                    'label' => 'Layanan Komersial & Kantor',
                    'prompt' => 'Jelaskan layanan desain interior untuk kantor dan ruang komersial.',
                ],
                [
                    'label' => 'Jadwal Konsultasi & Survey',
                    'prompt' => 'Bagaimana cara menjadwalkan konsultasi atau survei lokasi dengan tim arsitek?',
                ],
            ]
        ]);
    }
}
