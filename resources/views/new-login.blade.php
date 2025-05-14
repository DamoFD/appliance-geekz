<x-app-layout>

    @section('title', '🔐 Login – Access Your Appliance AI Account')
    @section('description', '🚪 Sign in to Appliance AI to troubleshoot appliances, track usage, and get instant repair insights from your personalized dashboard.')

    <main class="min-h-screen flex items-center justify-center bg-dark-900 px-4">
        <div class="w-full max-w-sm bg-[#0e1525] p-8 rounded-xl shadow-xl text-white font-inter space-y-6">

            <!-- Logo -->
            <div class="flex justify-center">
                <img src={{ asset('images/blue-swirl.webp') }} alt="AI Logo" class="w-16 h-16 rounded-full" />
            </div>

            <!-- Welcome Text -->
            <div class="text-center">
                <h1 class="text-2xl font-bold">Welcome to Appliance<span class="text-blue-400">AI!</span></h1>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <input type="email" name="email" placeholder="Enter your email"
                        class="w-full px-4 py-3 bg-[#1a2339] rounded-lg border border-transparent focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                </div>

                {{-- Password Input --}}
                <div x-data="{ show: false }" class="relative">
                    <input
                        :type="show ? 'text' : 'password'"
                        name="password"
                        placeholder="Enter your password"
                        class="w-full px-4 py-3 bg-[#1a2339] rounded-lg border border-transparent focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 pr-10"
                        required
                    >

                    <div
                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 cursor-pointer"
                        @click="show = !show"
                    >
                        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>

                        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.962 9.962 0 012.182-3.568m3.182-2.357A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.965 9.965 0 01-4.299 5.225M15 12a3 3 0 00-3-3m0 0a3 3 0 00-3 3m6 0a3 3 0 01-3 3m-6.364 6.364L20.485 3.515" />
                        </svg>
                    </div>
                </div>


                <div class="flex items-center justify-between text-sm text-gray-400">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="remember" class="form-checkbox bg-gray-700 border-gray-600 rounded">
                        <span class="ml-2">Remember Me</span>
                    </label>
                    <a href="#" class="text-blue-400 hover:underline">Forgot Password?</a>
                </div>

                <button type="submit"
                    class="w-full py-3 bg-blue-600 hover:bg-blue-700 transition rounded-lg font-semibold text-white text-lg">
                    Sign In
                </button>
            </form>

            <!-- Signup Link -->
            <div class="text-center text-sm text-gray-400">
                Don’t have an account?
                <a href="{{ route('register') }}" class="text-blue-400 hover:underline">Sign Up</a>
            </div>

            <!-- Divider -->
            <div class="text-center text-sm text-gray-500">Or continue with</div>

            <!-- Social Buttons -->
            <div class="flex space-x-4 justify-center">
                <a href="#" class="flex items-center px-4 py-2 bg-[#1a2339] border border-gray-600 rounded-lg text-sm hover:bg-gray-800">
                    Google
                </a>
                <a href="#" class="flex items-center px-4 py-2 bg-[#1a2339] border border-gray-600 rounded-lg text-sm hover:bg-gray-800">
                    Facebook
                </a>
            </div>

            <!-- Footer -->
            <div class="flex justify-between text-xs text-gray-500 pt-4">
                <a href="#" class="hover:underline">Terms of Service</a>
                <a href="#" class="hover:underline">Privacy Policy</a>
            </div>
        </div>
    </main>
</x-app-layout>
