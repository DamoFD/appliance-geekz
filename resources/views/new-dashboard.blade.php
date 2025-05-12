@php
    $user = Auth::user();
    $prompt_tokens = 0;
    $completion_tokens = 0;
    $total_tokens = 0;
    $web_requests = 0;
    foreach ($user->usage as $usage) {
        $prompt_tokens += $usage->prompt_tokens;
        $completion_tokens += $usage->completion_tokens;
        $total_tokens += $usage->total_tokens;
        if ($usage->model === 'gpt-4o-mini-search-preview') {
            $web_requests += 1;
        }
    }

    $prompt_cost = $total_tokens / 1000000 * 1.2;
    $search_cost = $web_requests / 1000 * 55;
@endphp

<x-app-layout>
    <main class="min-h-screen bg-dark-900 text-white font-inter px-6 pt-32 pb-12 max-w-4xl mx-auto">
        <div class="bg-[#0e1525] rounded-xl shadow-xl p-8 space-y-6">

            <!-- Greeting -->
            <div>
                <h1 class="text-3xl font-bold mb-1">Welcome back, {{ $user->name }}!</h1>
                <p class="text-gray-400 text-sm">Here's your Appliance AI dashboard.</p>
            </div>

            <!-- Usage Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center text-sm">
                <div class="bg-[#1a2339] rounded-lg p-6">
                    <p class="text-gray-400 mb-1">Prompt Tokens</p>
                    <p class="text-2xl font-semibold text-blue-400">{{ $prompt_tokens }}</p>
                </div>
                <div class="bg-[#1a2339] rounded-lg p-6">
                    <p class="text-gray-400 mb-1">Completion Tokens</p>
                    <p class="text-2xl font-semibold text-blue-400">{{ $completion_tokens }}</p>
                </div>
                <div class="bg-[#1a2339] rounded-lg p-6">
                    <p class="text-gray-400 mb-1">Total Usage</p>
                    <p class="text-2xl font-semibold text-blue-400">{{ $total_tokens }}</p>
                </div>
                <div class="bg-[#1a2339] rounded-lg p-6">
                    <p class="text-gray-400 mb-1">Web Requests</p>
                    <p class="text-2xl font-semibold text-blue-400">{{ $web_requests }}</p>
                </div>
                <div class="bg-[#1a2339] rounded-lg p-6">
                    <p class="text-gray-400 mb-1">Total Cost</p>
                    <p class="text-2xl font-semibold text-blue-400">${{ $prompt_cost + $search_cost }}</p>
                </div>
            </div>

            <!-- CTA Button -->
            <div class="pt-4">
                <a href="{{ route('app') }}"
                   class="w-full block text-center py-3 bg-blue-600 hover:bg-blue-700 transition rounded-lg font-semibold text-lg">
                    Launch Appliance AI
                </a>
            </div>

        </div>
    </main>
</x-app-layout>
