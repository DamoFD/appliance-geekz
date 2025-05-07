<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

    public function getFaults(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'max:50',
            'model' => 'max:50',
            'serial_number' => 'max:50',
        ]);

        $prompt = "Give 3 common fault codes for a {$validated['brand']} model {$validated['model']}.";

        $response = Http::withToken(env('OPENAI_API_KEY'))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4o-2024-08-06',
                'messages' => [
                    ['role' => 'system', 'content' => "You are an expert appliance repair technician. Return only valid JSON matching the schema: " . json_encode($this->faultSchema)],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'response_format' => [
                    'type' => 'json_object',
                ]
            ]);

        $content = $response->json()['choices'][0]['message']['content'];
        $json = json_decode($content, true);

        return response()->json($json);

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
}


    /**
    public function ask(Request $request)
    {
        $response = Http::withToken(env('OPENAI_API_KEY'))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are an expert appliance repair assistant.'],
                    ['role' => 'user', 'content' => $request->input('question')],
                ],
            ]);

        dd($response->json()['choices'][0]['message']['content']);
    }
*/
