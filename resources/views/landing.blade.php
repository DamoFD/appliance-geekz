<x-app-layout>
    <main>
        <div class="relative z-[2] p-4 md:p-12 lg:p-8 w-full h-screen flex flex-col lg:flex-row lg:items-center justify-center items-start max-w-7xl mx-auto">
            <div class="flex flex-col items-start">
                <h1 class="text-4xl font-bold font-inter text-white mt-32 lg:-mt-48">Diagnose Any Appliance Instantly</h1>
                <p class="text-gray-300 font-inter mt-2">Powered by AI. Backed by real service docs.</p>
                <a href={{ route('dashboard') }} class="relative z-[3] bg-brand-green px-4 py-2 rounded-full text-gray-800 hover:bg-[#0E6640] transition-colors ease-in-out duration-300 font-inter font-bold text-xl cursor-pointer mt-8">
                    Start Diagnosing
                </a>
            </div>
            <div class="-mt-20 relative mx-auto">
                <img src={{ asset('images/washer.png') }} class="w-full max-w-[500px]"/>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 hero-chat px-4 py-2">
                    <p class="text-white font-inter text-2xl">The UI isn't turning on.</p>
                </div>
            </div>
        </div>
        <img class="absolute top-0 left-0 w-full h-screen object-cover" src={{ asset('images/hero-image.png') }} />
        <div class="absolute top-0 left-0 w-full h-screen bg-black bg-opacity-40"></div>
    </main>
</x-app-layout>
