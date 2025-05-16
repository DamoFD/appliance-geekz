<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\AiUsage;
use Illuminate\Support\Facades\DB;

class AiController extends Controller
{
    private $faultSchema = [
        "type" => "object",
        "properties" => [
            "faults" => [
                "type" => "array",
                "items" => [
                    "type" => "object",
                    "properties" => [
                        "code" => ["type" => "string"],
                        "title" => ["type" => "string"],
                        "solution" => ["type" => "string"],
                    ],
                    "required" => ["code", "title", "solution"],
                ]
            ]
        ],
        "required" => ["faults"]
    ];

    private $testSchema = [
        "type" => "object",
        "properties" => [
            "steps" => [
                "type" => "array",
                "items" => [
                    "type" => "object",
                    "properties" => [
                        "step" => ["type" => "integer"],
                        "title" => ["type" => "string"],
                        "description" => ["type" => "string"],
                    ],
                    "required" => ["step", "title", "description"],
                ]
            ]
        ],
        "required" => ["steps"]
    ];

    public function getTestMode(Request $request)
    {
        $validated = $request->validate([
            'type' => 'max:50',
            'brand' => 'max:50',
            'model' => 'max:50',
            'serial_number' => 'max:50',
        ]);

        $prompt = "Use the web and explain to me step by step how to enter this {$validated['brand']} {$validated['type']}, model {$validated['model']} into diagnostic mode, and how to navigate the diagnostics in detail. Use emojis in the title and descriptions to help convey your message.";

        $response = Http::withToken(config('app.openai_api_key'))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4o-mini-search-preview',
                'web_search_options' => (object) [],
                'messages' => [
                    ['role' => 'system', 'content' => "You are an expert appliance repair technician"],
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

        $aiUsage = AiUsage::create([
            'user_id' => auth()->id(),
            'model' => 'gpt-4o-mini-search-preview',
            'prompt' => $prompt,
            'response' => $response->json()['choices'][0]['message']['content'],
            'prompt_tokens' => $response->json()['usage']['prompt_tokens'] ?? 0,
            'completion_tokens' => $response->json()['usage']['completion_tokens'] ?? 0,
            'total_tokens' => $response->json()['usage']['total_tokens'] ?? 0,
        ]);

        $data = $response->json();
        $message = $data['choices'][0]['message']['content'] ?? null;

        return response()->json([
            'assistant' => $message,
            'ai_usage_id' => $aiUsage->id
        ]);
    }

    public function getFaults(Request $request)
    {
        $validated = $request->validate([
            'type' => 'max:50',
            'brand' => 'max:50',
            'model' => 'max:50',
            'serial_number' => 'max:50',
        ]);

        $prompt = "Return all known fault codes for a {$validated['brand']} {$validated['type']}, model {$validated['model']}.";

        $response = Http::withToken(config('app.openai_api_key'))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4o-mini-2024-07-18',
                'messages' => [
                    ['role' => 'system', 'content' => "You are an expert appliance repair technician. Return only valid JSON matching the schema: " . json_encode($this->faultSchema)],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'response_format' => [
                    'type' => 'json_object',
                ]
            ]);

        $aiUsage = AiUsage::create([
            'user_id' => auth()->id(),
            'model' => 'gpt-4o-mini-2024-07-18',
            'prompt' => $prompt,
            'response' => $response->json()['choices'][0]['message']['content'],
            'prompt_tokens' => $response->json()['usage']['prompt_tokens'] ?? 0,
            'completion_tokens' => $response->json()['usage']['completion_tokens'] ?? 0,
            'total_tokens' => $response->json()['usage']['total_tokens'] ?? 0,
        ]);

        $content = $response->json()['choices'][0]['message']['content'];
        $json = json_decode($content, true);

        return response()->json([
            'faults' => $json,
            'ai_usage_id' => $aiUsage->id
        ]);

        /**return response()->json([
            'faults' => [
                [
                    'code' => 'F5E1',
                    'title' => 'Lid Switch Fault',
                    'solution' => 'Check switch continuity. Often caused by broken lid strike.',
                ],
                [
                    'code' => 'F7E5',
                    'title' => 'Shifter Fault',
                    'solution' => 'Gearcase or shifter failure, especially after large loads.',
                ],
                [
                    'code' => 'F0E2',
                    'title' => 'Oversuds',
                    'solution' => 'Too much detergent. Clean dispenser + run rinse cycle.',
                ]
            ]
        ]);
        */
    }

    private function createEmbedding($text)
    {
        $embedding = Http::withToken(config('app.openai_api_key'))
            ->post('https://api.openai.com/v1/embeddings', [
                'model' => 'text-embedding-3-small',
                'input' => $text,
            ]
        );

        return $embedding->json()['data'][0]['embedding'];
    }

    private function findTopChunks($embeddingVector)
    {
        $chunks = DB::table('manual_chunks')->get();
        $topMatches = collect();

        foreach ($chunks as $chunk) {
            $chunkVector = json_decode($chunk->embedding, true);

            // Cosine similarity
            $dotProduct = 0;
            $normA = 0;
            $normB = 0;

            for ($i = 0; $i < count($embeddingVector); $i++) {
                $dotProduct += $embeddingVector[$i] * $chunkVector[$i];
                $normA += pow($embeddingVector[$i], 2);
                $normB += pow($chunkVector[$i], 2);
            }

            $similarity = $dotProduct / (sqrt($normA) * sqrt($normB));
            $topMatches->push(['chunk' => $chunk, 'score' => $similarity]);
        }

        return $topMatches->sortByDesc('score')->take(3)->pluck('chunk');
    }

    public function chat(Request $request)
    {
        $validated = $request->validate([
            'type' => 'max:50',
            'brand' => 'max:50',
            'model' => 'max:50',
            'serial' => 'max:50',
            'chat' => 'required|array',
            'chat.*.role' => 'required|string|in:user,assistant,system',
            'chat.*.content' => 'required|string|max:10000',
        ]);

        $embeddingVector = $this->createEmbedding(end($validated['chat'])['content']);
        $topChunks = $this->findTopChunks($embeddingVector);

        $vectorSystemPrompt = "Relevant manual excerpts:\n\n";
        foreach ($topChunks as $chunk) {
            $vectorSystemPrompt .= "- " . trim($chunk->text) . "\n\n";
        }

        $response = Http::withToken(config('app.openai_api_key'))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4o-mini-search-preview',
                'web_search_options' => (object) [],
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "You are an expert appliance repair technician. The user that you are talking to is an expert technician looking for technical support from you. You are to use the web and/or the given relevant manual excerpts to find the following answers to the user's questions. Any technical questions, please check manualslib.com for technical manuals. Check searspartsdirect.com for any parts questions and prices. You are NOT to say check the user or service manual. That is YOUR job to provide to the tech asking for guidance. Type: {$validated['type']}. Brand: {$validated['brand']}. Model: {$validated['model']}. Serial: {$validated['serial']}."
                    ],
                    [
                        'role' => 'system',
                        'content' => $vectorSystemPrompt
                    ],
                    [
                        'role' => 'system',
                        'content' => 'You are speaking to a professional technician with many years of experience. They have a multimeter and any other tools required to repair a machine.'
                    ],
                    [
                        'role' => 'system',
                        'content' => 'Do not say refer to any manuals. You must provide information from the provided excerpts or the web.'
                    ],
                    [
                        'role' => 'user',
                        'content' => 'This unit is not working properly',
                    ],
                    [
                        'role' => 'assistant',
                        'content' => 'For a detailed explanation and testing procedure, you can refer to the service manual or consult the technical documentation.',
                    ],
                    [
                        'role' => 'user',
                        'content' => 'I am a professional appliance repair technician. Do not say refer to any manuals. I have no access to manuals for this unit.',
                    ],
                    [
                        'role' => 'assistant',
                        'content' => 'I will check the manuals for you from now on, what is your next question?',
                    ],
                    ...$validated['chat'],
                ],
            ]);

        $aiUsage = AiUsage::create([
            'user_id' => auth()->id(),
            'model' => 'gpt-4o-mini-search-preview',
            'prompt' => json_encode($validated['chat']),
            'response' => $response->json()['choices'][0]['message']['content'],
            'prompt_tokens' => $response->json()['usage']['prompt_tokens'] ?? 0,
            'completion_tokens' => $response->json()['usage']['completion_tokens'] ?? 0,
            'total_tokens' => $response->json()['usage']['total_tokens'] ?? 0,
        ]);

        $data = $response->json();
        $message = $data['choices'][0]['message']['content'] ?? null;

        return response()->json([
            'assistant' => $message,
            'ai_usage_id' => $aiUsage->id
        ]);
    }
}
