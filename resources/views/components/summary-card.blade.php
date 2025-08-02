@props(['title', 'amount', 'color'])

@php
    $colorClasses = [
        'green' => 'border-green-500 text-green-600 bg-green-100',
        'red' => 'border-red-500 text-red-600 bg-red-100',
        'blue' => 'border-blue-500 text-blue-600 bg-blue-100',
    ];
@endphp

<div class="bg-white border-l-4 {{ $colorClasses[$color] ?? '' }} shadow p-6 rounded-xl hover:scale-105 duration-300">
    <div class="flex justify-between">
        <div>
            <h3 class="text-sm text-gray-500 uppercase">{{ $title }}</h3>
            <p class="text-2xl font-bold text-gray-800 mt-1">Rp {{ $amount }}</p>
        </div>
        <div class="p-2 rounded-full {{ $colorClasses[$color] ?? '' }}">
            <svg class="w-6 h-6 {{ $colorClasses[$color] ?? '' }}" fill="currentColor" viewBox="0 0 20 20">
                <path d="M11 17a1 1 0 01-2 0v-5H5l5-6 5 6h-4v5z" />
            </svg>
        </div>
    </div>
</div>
