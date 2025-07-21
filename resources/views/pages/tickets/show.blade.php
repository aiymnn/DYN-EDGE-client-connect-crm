<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ticket Detail') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Back button --}}
            <div class="flex justify-end mb-4">
                <a href="{{ route('tickets.index') }}"
                    class="px-4 py-2 bg-white text-gray-700 text-sm font-semibold rounded-md shadow hover:bg-gray-100 transition">
                    Back
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Ticket Information</h3>

                <div class="divide-y">
                    {{-- Customer --}}
                    <div class="flex flex-col sm:flex-row justify-between py-2">
                        <span class="text-gray-600 font-medium w-full sm:w-1/3">Customer</span>
                        <span class="text-gray-900 w-full sm:w-2/3">{{ $ticket->customer->name ?? '-' }}</span>
                    </div>

                    {{-- Staff --}}
                    <div class="flex flex-col sm:flex-row justify-between py-2">
                        <span class="text-gray-600 font-medium w-full sm:w-1/3">Staff</span>
                        <span class="text-gray-900 w-full sm:w-2/3">{{ $ticket->staff->name ?? '-' }}</span>
                    </div>

                    {{-- Title --}}
                    <div class="flex flex-col sm:flex-row justify-between py-2">
                        <span class="text-gray-600 font-medium w-full sm:w-1/3">Title</span>
                        <span class="text-gray-900 w-full sm:w-2/3 break-words">{{ $ticket->title ?? '-' }}</span>
                    </div>

                    {{-- Description --}}
                    <div class="flex flex-col sm:flex-row justify-between py-2">
                        <span class="text-gray-600 font-medium w-full sm:w-1/3">Description</span>
                        <span class="text-gray-900 w-full sm:w-2/3 break-words">
                            {{ $ticket->description ?? '-' }}
                        </span>
                    </div>

                    {{-- Status --}}
                    <div class="flex flex-col sm:flex-row justify-between py-2">
                        <span class="text-gray-600 font-medium w-full sm:w-1/3">Status</span>
                        <span class="w-full sm:w-2/3">
                            @php
                                $statusColor = match ($ticket->status) {
                                    'open' => 'bg-green-100 text-green-800',
                                    'in_progress' => 'bg-yellow-100 text-yellow-800',
                                    'resolved' => 'bg-blue-100 text-blue-800',
                                    'closed' => 'bg-gray-200 text-gray-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };

                                $statusLabel = $ticket->status ? ucwords(str_replace('_', ' ', $ticket->status)) : '-';
                            @endphp
                            <span class="inline-flex items-center px-2 py-0.5 rounded font-medium {{ $statusColor }}">
                                {{ $statusLabel }}
                            </span>
                        </span>
                    </div>

                    {{-- Priority --}}
                    <div class="flex flex-col sm:flex-row justify-between py-2">
                        <span class="text-gray-600 font-medium w-full sm:w-1/3">Priority</span>
                        <span class="w-full sm:w-2/3">
                            @php
                                $priorityColor = match ($ticket->priority) {
                                    'low' => 'bg-green-100 text-green-800',
                                    'medium' => 'bg-yellow-100 text-yellow-800',
                                    'high' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };

                                $priorityLabel = $ticket->priority ? ucfirst($ticket->priority) : '-';
                            @endphp
                            <span class="inline-flex items-center px-2 py-0.5 rounded font-medium {{ $priorityColor }}">
                                {{ $priorityLabel }}
                            </span>
                        </span>
                    </div>

                    {{-- Created At --}}
                    <div class="flex flex-col sm:flex-row justify-between py-2">
                        <span class="text-gray-600 font-medium w-full sm:w-1/3">Created At</span>
                        <span class="text-gray-900 w-full sm:w-2/3">
                            {{ $ticket->created_at ? $ticket->created_at->format('d F Y, h:i A') : '-' }}
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
