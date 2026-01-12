<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TestApiController extends Controller
{
    public function ask(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
        ]);

        // URL de ton FastAPI en local
        $url = "http://127.0.0.1:8000/ask";

        try {
            $response = Http::timeout(30)->post($url, [
                'question' => $request->question
            ]);

            $data = $response->json();
            return response()->json(['answer' => $data['answer'] ?? 'Pas de réponse']);
        } catch (\Exception $e) {
            return response()->json([
                'answer' => "Le bot est temporairement indisponible.",
                'error' => $e->getMessage()
            ]);
        }
    }
}