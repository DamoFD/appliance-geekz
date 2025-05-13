<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Define start of current day (midnight)
        $todayStart = now()->startOfDay();

        // Filter usage records from today only
        $usages = $user->usage()->where('created_at', '>=', $todayStart)->get();

        $prompt_tokens = 0;
        $completion_tokens = 0;
        $total_tokens = 0;
        $web_requests = 0;

        foreach ($usages as $usage) {
            $prompt_tokens += $usage->prompt_tokens;
            $completion_tokens += $usage->completion_tokens;
            $total_tokens += $usage->total_tokens;
            if ($usage->model === 'gpt-4o-mini-search-preview') {
                $web_requests += 1;
            }
        }

        $prompt_cost = $total_tokens / 1000000 * 1.2;
        $search_cost = $web_requests / 1000 * 55;
        $total_cost = $prompt_cost + $search_cost;

        if ($total_cost >= 2) {
            return response()->json(['error' => "You have reached your daily token limit. Please wait until {$todayStart->toDateTimeString()} before making another request."], 429);
        }

        return $next($request);
    }
}
