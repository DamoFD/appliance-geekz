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
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-[#1a2339] text-gray-400 text-sm">
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th class="px-4 py-3">Review</th>
                            <th class="px-4 py-3">Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($feedbacks as $feedback)
                        <tr class="border-t border-gray-800">
                            <td class="px-4 py-3">{{ $feedback->id }}</td>
                            <td class="px-4 py-3 text-blue-400 underline"><a href="{{ route('admin.show-feedback', $feedback) }}">{{ $feedback->feedback === 'yes' ? 'Positive' : 'Negative' }}</a></td>
                            <td class="px-4 py-3">{{ $feedback->created_at->format('Y-m-d') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </main>
</x-app-layout>
