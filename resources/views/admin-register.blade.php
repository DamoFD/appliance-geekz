<x-app-layout>
    <main class="min-h-screen flex items-center justify-center bg-dark-900 px-4">
        <div class="w-full max-w-sm bg-[#0e1525] p-8 rounded-xl shadow-xl text-white font-inter space-y-6">

            <!-- Logo -->
            <div class="flex justify-center">
                <img src={{ asset('images/blue-swirl.png') }} alt="AI Logo" class="w-16 h-16 rounded-full" />
            </div>

            <!-- Welcome Text -->
            <div class="text-center">
                <h1 class="text-2xl font-bold">Welcome to Appliance<span class="text-blue-400">AI!</span></h1>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('admin.store-user') }}" class="space-y-4">
                @csrf

                <div>
                    <input type="text" name="name" placeholder="Enter your name"
                        class="w-full px-4 py-3 bg-[#1a2339] rounded-lg border border-transparent focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <input type="email" name="email" placeholder="Enter your email"
                        class="w-full px-4 py-3 bg-[#1a2339] rounded-lg border border-transparent focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <input type="password" name="password" placeholder="Enter your password"
                        class="w-full px-4 py-3 bg-[#1a2339] rounded-lg border border-transparent focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <input type="password" name="password_confirmation" placeholder="Confirm password"
                        class="w-full px-4 py-3 bg-[#1a2339] rounded-lg border border-transparent focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                    @error('password_confirmation')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full py-3 bg-blue-600 hover:bg-blue-700 transition rounded-lg font-semibold text-white text-lg">
                    Register
                </button>
            </form>

            <!-- Signup Link -->
            <div class="text-center text-sm text-gray-400">
                Already have an account?
                <a href="{{ route('login') }}" class="text-blue-400 hover:underline">Sign In</a>
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
