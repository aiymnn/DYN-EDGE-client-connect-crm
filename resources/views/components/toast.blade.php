@props(['type' => 'success', 'message' => ''])

@php
    $bgColor = $type === 'success' ? 'bg-green-500' : 'bg-red-500';
    $icon = $type === 'success' ? '✓' : '✕';
@endphp

<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition.opacity.duration.500ms
    class="fixed top-5 right-5 {{ $bgColor }} text-white px-4 py-3 rounded shadow-lg flex items-center space-x-2 z-50">
    <span class="text-lg font-bold">{{ $icon }}</span>
    <span class="text-sm">{{ $message }}</span>
    <button @click="show = false" class="ml-2 text-white hover:text-gray-200 focus:outline-none">
        &times;
    </button>
</div>
