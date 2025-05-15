<x-app-layout>
    <section class="w-full min-h-screen flex flex-col items-center justify-center">
        <div class="w-full max-w-sm bg-[#0e1525] p-8 rounded-xl shadow-xl text-white font-inter space-y-6">

            <!-- Logo -->
            <div class="flex justify-center">
                <img src={{ asset('images/blue-swirl.webp') }} alt="AI Logo" class="w-16 h-16 rounded-full" />
            </div>

            <div class="mb-4 text-sm text-gray-400">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button>
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </section>
</x-app-layout>
