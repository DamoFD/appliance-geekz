@php
    $aiUsage = $feedback->AiUsage;
    $web_requests = 0;
    $total_tokens = $aiUsage->total_tokens;
    if ($aiUsage->model === 'gpt-4o-mini-search-preview') {
        $web_requests = 1;
    }

    $prompt_cost = $total_tokens / 1000000 * 1.2;
    $search_cost = $web_requests / 1000 * 55;
@endphp

<x-app-layout>
    <main class="min-h-screen bg-dark-900 text-white font-inter px-6 pt-32 pb-12 max-w-6xl mx-auto">

        <!-- Admin Nav -->
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.index') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg font-semibold">Dashboard</a>
            <a href="{{ route('admin.waitlist') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg font-semibold">Waitlist</a>
        </div>

        <div class="bg-[#0e1525] rounded-xl shadow-xl p-8 space-y-6 mt-4">

            <!-- Header -->
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold mb-1">Feedback Management</h1>
                    <p class="text-gray-400 text-sm">Review feedback from users.</p>
                </div>
            </div>

            <!-- User Table -->
            <div class="flex flex-col space-y-4">
                <p><b>ID:</b> {{ $feedback->id }}</p>
                <p><b>Review:</b> {{ $feedback->feedback === 'yes' ? 'Positive' : 'Negative' }}</p>
                <p><b>Created:</b> {{ $feedback->created_at->format('Y-m-d') }}</p>
                <p><b>User:</b> {{ $aiUsage->user->name }}</p>
                <p><b>Model:</b> {{ $aiUsage->model }}</p>
                <p><b>Prompt:</b> {{ $aiUsage->prompt }}</p>
                <p><b>Response:</b> {{ $aiUsage->response }}</p>
                <p><b>Prompt Tokens:</b> {{ $aiUsage->prompt_tokens }}</p>
                <p><b>Completion Tokens:</b> {{ $aiUsage->completion_tokens }}</p>
                <p><b>Total Tokens:</b> {{ $aiUsage->total_tokens }}</p>
                <p><b>AI Usage Created:</b> {{ $aiUsage->created_at }}</p>
                <p><b>Cost:</b> {{ $prompt_cost + $search_cost }}</p>
            </div>

        </div>
    </main>
</x-app-layout>
