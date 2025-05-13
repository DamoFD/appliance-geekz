<x-app-layout>

    @section('title', '⏳ Join the Waitlist – Get Early Access to Appliance AI')
    @section('description', '🚀 Be among the first to try Appliance AI. Join our beta waitlist to get early access to AI-powered appliance diagnostics and repair tools.')

    <main class="bg-black min-h-screen w-full flex items-center justify-center text-white font-inter px-4">

        <div class="bg-[#0e1525] p-8 max-w-md w-full rounded-xl shadow-xl space-y-6 text-center">
            <img src={{ asset('images/blue-swirl.webp') }} alt="AI Icon" class="mx-auto w-16 h-16 rounded-full" />

            <h1 class="text-2xl font-bold text-blue-400">We're in Beta</h1>
            <p class="text-gray-300">Appliance AI is invite-only for now. Want to be one of the first testers?</p>

            @if(session('success'))
                <div class="text-green-400 bg-green-900 rounded p-3">
                    {{ session('success') }}
                </div>
            @else
                <form action="{{ route('waitlist.submit') }}" method="POST" class="space-y-4 text-left">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm text-gray-400 mb-1">Name</label>
                        <input type="text" name="name" id="name" required
                            class="w-full px-4 py-3 bg-[#1a2339] rounded-lg border border-transparent focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm text-gray-400 mb-1">Email</label>
                        <input type="email" name="email" id="email" required
                            class="w-full px-4 py-3 bg-[#1a2339] rounded-lg border border-transparent focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full py-3 bg-blue-600 hover:bg-blue-700 transition rounded-lg font-semibold text-white text-lg">
                        Join the Waitlist
                    </button>
                </form>
            @endif

            <div class="pt-4">
                <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:underline">&larr; Back to login</a>
            </div>
        </div>

    </main>
</x-app-layout>
