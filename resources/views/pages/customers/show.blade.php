<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customer Details') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Back button --}}
            <div class="flex justify-end mb-4">
                <a href="{{ route('customers.index') }}"
                    class="px-4 py-2 bg-white text-gray-700 text-sm font-semibold rounded-md shadow hover:bg-gray-100 transition">
                    Back
                </a>
            </div>


            <!-- Interactions & Ticket -->
            <div class="flex flex-wrap gap-4 mb-3">
                <div class="flex-1 min-w-[250px] bg-white p-4 rounded shadow">
                    <div class="flex flex-col items-center justify-center h-full">
                        <div class="text-sm text-gray-500">Interactions</div>
                        <div class="text-2xl font-bold text-purple-700">{{ $customer->interactions_count }}</div>
                    </div>
                </div>
                <div class="flex-1 min-w-[250px] bg-white p-4 rounded shadow">
                    <div class="flex flex-col items-center justify-center h-full">
                        <div class="text-sm text-gray-500">Ticket</div>
                        <div class="text-2xl font-bold text-gray-800">{{ $customer->tickets_count }}</div>
                    </div>
                </div>
            </div>

            <!-- Open, In Progress, Resolved, Closed -->
            <div class="flex flex-wrap gap-4 mb-3">
                <div class="flex-1 min-w-[200px] bg-white p-4 rounded shadow">
                    <div class="flex flex-col items-center justify-center h-full">
                        <div class="text-sm text-gray-500">Open</div>
                        <div class="text-2xl font-bold text-green-700">{{ $customer->open_tickets_count }}</div>
                    </div>
                </div>
                <div class="flex-1 min-w-[200px] bg-white p-4 rounded shadow">
                    <div class="flex flex-col items-center justify-center h-full">
                        <div class="text-sm text-gray-500">In Progress</div>
                        <div class="text-2xl font-bold text-yellow-700">{{ $customer->in_progress_tickets_count }}</div>
                    </div>
                </div>
                <div class="flex-1 min-w-[200px] bg-white p-4 rounded shadow">
                    <div class="flex flex-col items-center justify-center h-full">
                        <div class="text-sm text-gray-500">Resolved</div>
                        <div class="text-2xl font-bold text-gray-800">{{ $customer->resolved_tickets_count }}</div>
                    </div>
                </div>
                <div class="flex-1 min-w-[200px] bg-white p-4 rounded shadow">
                    <div class="flex flex-col items-center justify-center h-full">
                        <div class="text-sm text-gray-500">Closed</div>
                        <div class="text-2xl font-bold text-pink-700">{{ $customer->closed_tickets_count }}</div>
                    </div>
                </div>
            </div>


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Customer Profile</h3>
                <div class="divide-y">
                    <div class="flex flex-col sm:flex-row justify-between py-2">
                        <span class="text-gray-600 font-medium w-full sm:w-1/3">Name</span>
                        <span class="text-gray-900 w-full sm:w-2/3">{{ $customer->name ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row justify-between py-2">
                        <span class="text-gray-600 font-medium w-full sm:w-1/3">ID Number</span>
                        <span class="text-gray-900 w-full sm:w-2/3">{{ $customer->id_number ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row justify-between py-2">
                        <span class="text-gray-600 font-medium w-full sm:w-1/3">Email</span>
                        <span class="text-gray-900 w-full sm:w-2/3">{{ $customer->email ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row justify-between py-2">
                        <span class="text-gray-600 font-medium w-full sm:w-1/3">Phone</span>
                        <span class="text-gray-900 w-full sm:w-2/3">{{ $customer->phone ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row justify-between py-2">
                        <span class="text-gray-600 font-medium w-full sm:w-1/3">Address</span>
                        <span class="text-gray-900 w-full sm:w-2/3">{{ $customer->address ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row justify-between py-2">
                        <span class="text-gray-600 font-medium w-full sm:w-1/3">Notes</span>
                        <span class="text-gray-900 w-full sm:w-2/3">{{ $customer->notes ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row justify-between py-2">
                        <span class="text-gray-600 font-medium w-full sm:w-1/3">Registered at</span>
                        <span class="text-gray-900 w-full sm:w-2/3">
                            {{ $customer->created_at ? $customer->created_at->format('d F Y, h:i A') : '-' }}
                        </span>
                    </div>
                    <div class="flex flex-col sm:flex-row justify-between py-2">
                        <span class="text-gray-600 font-medium w-full sm:w-1/3">Status</span>
                        <span class="text-gray-900 w-full sm:w-2/3">
                            <span
                                class="px-2 py-1 rounded
                                            @if ($customer->deleted_at) bg-red-100 text-red-800
                                            @else bg-green-100 text-green-800 @endif">
                                {{ $customer->deleted_at ? 'Inactive' : 'Active' }}
                            </span>
                        </span>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between py-2">
                        @if ($customer->deleted_at)
                            <form action="{{ route('customers.restore', ['customer' => $customer->id]) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to activate this account?');"
                                class="inline">
                                @csrf
                                <button type="submit"
                                    class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-md shadow transition">
                                    Activate this account
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
