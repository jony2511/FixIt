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
            
            // Create a maintenance-focused context for the AI
            $systemPrompt = "You are a helpful maintenance assistant for FixIT, a facility management system. 
                           Provide concise, practical advice about facility maintenance issues like plumbing, 
                           electrical, HVAC, IT support, cleaning, security, and general maintenance. 
                           Keep responses under 200 words and focus on actionable solutions. 
                           If you cannot help with something, politely redirect to creating a maintenance request.";

            // Try to get AI response using Hugging Face's free API
            $response = $this->getHuggingFaceResponse($question, $systemPrompt);
            
            if (!$response) {
                // Fallback to rule-based responses
                $response = $this->getFallbackResponse($question);
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
     * Get response from Hugging Face free API
     */
    private function getHuggingFaceResponse($question, $systemPrompt)
    {
        try {
            $client = new Client();
            
            // Using a free model from Hugging Face
            $response = $client->post('https://api-inference.huggingface.co/models/microsoft/DialoGPT-medium', [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('HUGGINGFACE_API_KEY', ''), // Optional - works without key but with rate limits
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'inputs' => $systemPrompt . "\n\nUser: " . $question . "\nAssistant:",
                    'parameters' => [
                        'max_length' => 200,
                        'temperature' => 0.7,
                        'return_full_text' => false
                    ]
                ],
                'timeout' => 10
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            
            if (isset($data[0]['generated_text'])) {
                return trim($data[0]['generated_text']);
            }
            
            return null;
        } catch (\Exception $e) {
            Log::warning('Hugging Face API failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Fallback rule-based responses for common maintenance questions
     */
    private function getFallbackResponse($question)
    {
        $question = strtolower($question);
        
        // Common maintenance keywords and responses
        $responses = [
            // Plumbing
            ['keywords' => ['plumb', 'toilet', 'clog', 'leak', 'drain', 'faucet', 'sink'], 
             'response' => "🔧 **Plumbing Help:** First, check if it's a simple blockage. For toilets, try plunging first. For leaks, turn off the water supply under the fixture. If there's flooding or no hot water, please create an urgent maintenance request immediately. Never use chemical drain cleaners on severe blockages."],
            
            // Electrical
            ['keywords' => ['electric', 'power', 'outlet', 'light', 'switch', 'breaker', 'spark'], 
             'response' => "⚡ **Electrical Safety:** Never attempt DIY electrical work! If power is out, check your circuit breaker panel first. For flickering lights or sparking outlets, turn off power at the breaker immediately and create an urgent maintenance request. This could be a fire hazard."],
            
            // HVAC
            ['keywords' => ['hvac', 'heat', 'cool', 'air', 'temperature', 'thermostat', 'vent'], 
             'response' => "🌡️ **HVAC Troubleshooting:** 1) Check and replace air filter if dirty 2) Ensure all vents are open and unblocked 3) Check thermostat settings and replace batteries 4) For radiators, check if pilot light is on. If still not working, create a maintenance request."],
            
            // IT Support
            ['keywords' => ['computer', 'laptop', 'wifi', 'internet', 'network', 'printer', 'screen'], 
             'response' => "💻 **IT Quick Fixes:** 1) Try restarting your device first 2) Check all cable connections 3) For network issues, restart your router/modem 4) Clear browser cache for web issues. If problems persist, create an IT support request with specific error messages."],
            
            // Cleaning
            ['keywords' => ['clean', 'dirty', 'trash', 'garbage', 'mess', 'sanitize'], 
             'response' => "🧽 **Cleaning Services:** For routine cleaning, ensure areas are clear of personal items. For deep cleaning or special requirements (carpet cleaning, window washing), please submit a detailed cleaning request. Emergency spills should be reported immediately."],
            
            // Security
            ['keywords' => ['lock', 'key', 'door', 'security', 'access', 'card'], 
             'response' => "🔐 **Security Issues:** Never force stuck locks! For lost keys/cards, contact security immediately. For broken locks or security concerns, create an urgent maintenance request. Your safety is our priority - don't hesitate to report any security issues."],
            
            // Water Issues
            ['keywords' => ['water', 'pressure', 'hot', 'cold', 'shower', 'bath'], 
             'response' => "💧 **Water Problems:** If no water, check if it's building-wide first. For low pressure, try cleaning faucet aerators. Run cold water for 2-3 minutes if discolored. No hot water or persistent issues need a maintenance request with location details."],
            
            // Maintenance Requests
            ['keywords' => ['request', 'submit', 'create', 'help', 'problem'], 
             'response' => "📝 **Creating Requests:** To submit a maintenance request: 1) Click 'New Request' 2) Choose the right category 3) Describe the issue clearly 4) Add photos if helpful 5) Set priority level. Our team will respond based on urgency!"],

            // General Greetings
            ['keywords' => ['hello', 'hi', 'hey', 'help'], 
             'response' => "👋 **Welcome!** I'm here to help with maintenance questions! I can assist with plumbing, electrical, HVAC, IT, cleaning, and security issues. Try asking about a specific problem, or use the quick suggestion buttons below."]
        ];

        // Check for keyword matches
        foreach ($responses as $response) {
            foreach ($response['keywords'] as $keyword) {
                if (strpos($question, $keyword) !== false) {
                    return $response['response'];
                }
            }
        }

        // Special responses for common questions
        if (strpos($question, '?') !== false) {
            return "🤔 **Great Question!** I'd be happy to help with your maintenance question. For the most accurate assistance, try being specific about the issue (e.g., 'toilet won't flush' or 'no hot water'). You can also create a detailed maintenance request for expert technical support!";
        }

        // Default response
        return "🏢 **FixIT Assistant:** I'm here to help with facility maintenance questions! Ask me about plumbing, electrical, HVAC, IT support, cleaning, or security issues. For complex problems, I'll guide you to create a maintenance request where our expert technicians can provide hands-on help.";
    }
}
