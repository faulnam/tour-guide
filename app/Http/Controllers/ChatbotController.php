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
                    'label' => 'Itinerary Raja Ampat 4D3N',
                    'prompt' => 'Berapa estimasi biaya dan rekomendasi itinerary 4D3N ke Wayag & Misool Raja Ampat beserta pemandu?',
                ],
                [
                    'label' => 'Sailing Komodo & Labuan Bajo',
                    'prompt' => 'Kapan musim terbaik untuk liveaboard ke Pulau Padar, Pink Beach, dan snorkeling bersama Manta Ray?',
                ],
                [
                    'label' => 'Paket Sunrise Bromo & Ijen Blue Fire',
                    'prompt' => 'Apa saja persiapan dan perlengkapan mendaki untuk tur sunrise Bromo dan Kawah Ijen?',
                ],
                [
                    'label' => 'Pemandu Budaya Bali & Toraja',
                    'prompt' => 'Bagaimana etika berkunjung dan rute wisata warisan budaya spiritual di Bali dan Tana Toraja?',
                ],
            ]
        ]);
    }
}
