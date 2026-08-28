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
                    'label' => 'Estimasi Remap ECU Mobil/Motor',
                    'prompt' => 'Berapa perkiraan kenaikan tenaga (HP & Torsi) dan biaya untuk Remap ECU Stage 2?',
                ],
                [
                    'label' => 'Konsep Motor Custom Cafe Racer',
                    'prompt' => 'Saya ingin custom motor Yamaha XSR 155 / Honda CB jadi Cafe Racer, apa saja yang perlu diubah?',
                ],
                [
                    'label' => 'Paket Widebody & Cat Oven Spies Hecker',
                    'prompt' => 'Bagaimana proses pembuatan custom bodykit widebody dan cat oven di Apex Garage?',
                ],
                [
                    'label' => 'Cara Booking & Pembayaran DP',
                    'prompt' => 'Bagaimana cara booking jadwal servis atau dyno test di website Apex Garage?',
                ],
            ]
        ]);
    }
}
