@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'text-white border-transparent focus:outline-none bg-[#1a2339] focus:border-blue-500 focus:ring-blue-500 focus:ring-1 rounded-md shadow-sm']) }}>
