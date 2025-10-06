<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class AIChatController extends Controller
{
    /**
     * Handle AI chat requests
     */
    public function chat(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:500',
        ]);

        try {
            $question = $request->question;
            
            // Create a general-purpose AI context 
            $systemPrompt = "You are an intelligent AI assistant integrated into FixIT, a facility management system. 
                           You can answer ANY question - whether it's about maintenance, general knowledge, science, 
                           technology, cooking, travel, or any topic the user asks about. 
                           Provide helpful, accurate, and concise responses (under 200 words). 
                           Be friendly, professional, and informative. If asked about maintenance specifically, 
                           you can also suggest creating a maintenance request in the FixIT system for hands-on help.";

            // Always try Gemini AI first
            $response = $this->getGeminiResponse($question, $systemPrompt);
            
            // Only use fallback if Gemini completely fails
            if (!$response) {
                $response = "I'm having trouble connecting to my AI service right now. Please try again in a moment, or create a maintenance request if you need immediate technical assistance.";
            }

            return response()->json([
                'success' => true,
                'response' => $response,
                'timestamp' => now()->format('H:i')
            ]);

        } catch (\Exception $e) {
            Log::error('AI Chat error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'response' => 'I apologize, but I\'m experiencing technical difficulties right now. Please try again later or create a maintenance request for immediate assistance.',
                'timestamp' => now()->format('H:i')
            ], 500);
        }
    }

    /**
     * Get response from Google Gemini AI API
     */
    private function getGeminiResponse($question, $systemPrompt)
    {
        try {
            $apiKey = env('GEMINI_API_KEY');
            if (!$apiKey) {
                Log::warning('Gemini API key not configured');
                return null;
            }

            $client = new Client();
            
            // Combine system prompt with user question
            $fullPrompt = $systemPrompt . "\n\nUser: " . $question . "\n\nAssistant:";
            
            Log::info('Sending request to Gemini AI', ['question' => $question]);
            
            // Use the working Gemini 2.0 Flash model
            $response = $client->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}", [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'contents' => [
                        [
                            'parts' => [
                                [
                                    'text' => $fullPrompt
                                ]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.8,
                        'maxOutputTokens' => 300,
                    ]
                ],
                'timeout' => 20
            ]);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);
            
            Log::info('Gemini API Response', [
                'status' => $statusCode,
                'has_candidates' => isset($data['candidates']),
                'response_keys' => array_keys($data ?? [])
            ]);
            
            // Extract the generated text from Gemini's response
            if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                $aiResponse = trim($data['candidates'][0]['content']['parts'][0]['text']);
                Log::info('Gemini AI response successful', ['response_length' => strlen($aiResponse)]);
                return "🤖 **Gemini AI:** " . $aiResponse;
            }
            
            // Check for errors in response
            if (isset($data['error'])) {
                Log::error('Gemini API Error', ['error' => $data['error']]);
                return null;
            }
            
            Log::warning('Gemini API returned unexpected response format', ['data' => $data]);
            return null;
            
        } catch (\Exception $e) {
            Log::error('Gemini AI API failed', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'question' => $question
            ]);
            return null;
        }
    }




}
