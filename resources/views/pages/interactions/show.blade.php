<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Interaction Detail') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Back button --}}
            <div class="flex justify-end mb-4">
                <a href="{{ route('interactions.index') }}"
                    class="px-4 py-2 bg-white text-gray-700 text-sm font-semibold rounded-md shadow hover:bg-gray-100 transition">
                    Back
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Interaction Information</h3>

                <div class="divide-y">
                    <div class="flex flex-col sm:flex-row justify-between py-2">
                        <span class="text-gray-600 font-medium w-full sm:w-1/3">Customer</span>
                        <span class="text-gray-900 w-full sm:w-2/3">{{ $interaction->customer->name ?? '-' }}</span>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between py-2">
                        <span class="text-gray-600 font-medium w-full sm:w-1/3">Staff</span>
                        <span class="text-gray-900 w-full sm:w-2/3">{{ $interaction->staff->name ?? '-' }}</span>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between py-2">
                        <span class="text-gray-600 font-medium w-full sm:w-1/3">Type</span>
                        <span class="text-gray-900 w-full sm:w-2/3">{{ $interaction->type ?? '-' }}</span>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between py-2">
                        <span class="text-gray-600 font-medium w-full sm:w-1/3">Date & Time</span>
                        <span class="text-gray-900 w-full sm:w-2/3">
                            {{ $interaction->datetime ? \Carbon\Carbon::parse($interaction->datetime)->format('d F Y, h:i A') : '-' }}
                        </span>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between py-2">
                        <span class="text-gray-600 font-medium w-full sm:w-1/3">Notes</span>
                        <span class="text-gray-900 w-full sm:w-2/3 break-words">
                            {{ $interaction->notes ?? '-' }}
                        </span>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between py-2">
                        <span class="text-gray-600 font-medium w-full sm:w-1/3">Created At</span>
                        <span class="text-gray-900 w-full sm:w-2/3">
                            {{ $interaction->created_at ? $interaction->created_at->format('d F Y, h:i A') : '-' }}
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
