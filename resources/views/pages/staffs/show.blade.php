<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Staff Details') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Back Button -->
            <div class="flex justify-end mb-4">
                <a href="{{ route('users.index') }}"
                    class="px-4 py-2 bg-white text-gray-700 text-sm font-semibold rounded-md shadow hover:bg-gray-100 transition">
                    Back
                </a>
            </div>

            <!-- Interactions & Ticket KPI -->
            <div class="flex flex-wrap gap-4 mb-3">
                <div class="flex-1 min-w-[250px] bg-white p-4 rounded shadow">
                    <div class="flex flex-col items-center justify-center h-full">
                        <div class="text-sm text-gray-500">Interactions Handled</div>
                        <div class="text-2xl font-bold text-purple-700">{{ $staff->interactions_count }}</div>
                    </div>
                </div>
                <div class="flex-1 min-w-[250px] bg-white p-4 rounded shadow">
                    <div class="flex flex-col items-center justify-center h-full">
                        <div class="text-sm text-gray-500">Tickets Assigned</div>
                        <div class="text-2xl font-bold text-gray-800">{{ $staff->tickets_count }}</div>
                    </div>
                </div>
            </div>

            <!-- Ticket Status Breakdown -->
            <div class="flex flex-wrap gap-4 mb-3">
                <div class="flex-1 min-w-[200px] bg-white p-4 rounded shadow">
                    <div class="flex flex-col items-center justify-center h-full">
                        <div class="text-sm text-gray-500">Open</div>
                        <div class="text-2xl font-bold text-green-700">{{ $staff->open_tickets_count }}</div>
                    </div>
                </div>
                <div class="flex-1 min-w-[200px] bg-white p-4 rounded shadow">
                    <div class="flex flex-col items-center justify-center h-full">
                        <div class="text-sm text-gray-500">In Progress</div>
                        <div class="text-2xl font-bold text-yellow-700">{{ $staff->in_progress_tickets_count }}</div>
                    </div>
                </div>
                <div class="flex-1 min-w-[200px] bg-white p-4 rounded shadow">
                    <div class="flex flex-col items-center justify-center h-full">
                        <div class="text-sm text-gray-500">Resolved</div>
                        <div class="text-2xl font-bold text-gray-800">{{ $staff->resolved_tickets_count }}</div>
                    </div>
                </div>
                <div class="flex-1 min-w-[200px] bg-white p-4 rounded shadow">
                    <div class="flex flex-col items-center justify-center h-full">
                        <div class="text-sm text-gray-500">Closed</div>
                        <div class="text-2xl font-bold text-pink-700">{{ $staff->closed_tickets_count }}</div>
                    </div>
                </div>
            </div>

            <!-- Staff Profile -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Staff Profile</h3>
                <div class="divide-y">
                    <div class="flex flex-col sm:flex-row justify-between py-2">
                        <span class="text-gray-600 font-medium w-full sm:w-1/3">Name</span>
                        <span class="text-gray-900 w-full sm:w-2/3">{{ $staff->name ?? '-' }}</span>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between py-2">
                        <span class="text-gray-600 font-medium w-full sm:w-1/3">Email</span>
                        <span class="text-gray-900 w-full sm:w-2/3">{{ $staff->email ?? '-' }}</span>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between py-2">
                        <span class="text-gray-600 font-medium w-full sm:w-1/3">Phone</span>
                        <span class="text-gray-900 w-full sm:w-2/3">{{ $staff->phone ?? '-' }}</span>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between py-2">
                        <span class="text-gray-600 font-medium w-full sm:w-1/3">Role</span>
                        <span
                            class="text-gray-900 w-full sm:w-2/3 capitalize">{{ $staff->role === 'R01' ? 'Admin' : 'Staff' }}</span>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between py-2">
                        <span class="text-gray-600 font-medium w-full sm:w-1/3">Registered at</span>
                        <span class="text-gray-900 w-full sm:w-2/3">
                            {{ $staff->created_at ? $staff->created_at->format('d F Y, h:i A') : '-' }}
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
