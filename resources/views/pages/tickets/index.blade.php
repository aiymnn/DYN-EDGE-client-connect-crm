<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Tickets') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col gap-2 md:gap-4 mb-4">

                {{-- New Ticket --}}
                <div class="flex justify-end">
                    <a href="{{ route('tickets.create') }}"
                        class="px-4 py-2 bg-white text-gray-700 text-sm font-semibold rounded-md shadow hover:bg-gray-100 transition">
                        New Ticket
                    </a>
                </div>

                {{-- Filter Form --}}
                <form method="GET" action="{{ route('tickets.index') }}" class="flex flex-wrap gap-2">

                    {{-- Entries --}}
                    <div class="flex flex-col">
                        <label for="entries" class="text-sm text-gray-600">Entries</label>
                        <select id="entries" name="entries"
                            class="block w-full sm:w-auto border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm">
                            <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10 entries</option>
                            <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25 entries</option>
                            <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50 entries</option>
                        </select>
                    </div>

                    {{-- Customer --}}
                    <div class="flex flex-col">
                        <label for="name" class="text-sm text-gray-600">Customer</label>
                        <input id="name" type="text" name="name" placeholder="Search customer"
                            class="block w-full sm:w-auto border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm"
                            value="{{ request('name') }}">
                    </div>

                    {{-- Staff --}}
                    @can('admin')
                        <div class="flex flex-col">
                            <label for="staff" class="text-sm text-gray-600">Staff</label>
                            <input id="staff" type="text" name="staff" placeholder="Search staff"
                                class="block w-full sm:w-auto border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm"
                                value="{{ request('staff') }}">
                        </div>
                    @endcan

                    {{-- Status --}}
                    <div class="flex flex-col">
                        <label for="status" class="text-sm text-gray-600">Status</label>
                        <select name="status" id="status"
                            class="block w-full sm:w-auto border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm">
                            <option value="">-- All Statuses --</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}"
                                    {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Priority --}}
                    <div class="flex flex-col">
                        <label for="priority" class="text-sm text-gray-600">Priority</label>
                        <select name="priority" id="priority"
                            class="block w-full sm:w-auto border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm">
                            <option value="">-- All Priorities --</option>
                            @foreach ($priorities as $priority)
                                <option value="{{ $priority }}"
                                    {{ request('priority') == $priority ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $priority)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Start Date --}}
                    <div class="flex flex-col">
                        <label for="start_date" class="text-sm text-gray-600">Start Date</label>
                        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                            class="block w-full sm:w-auto border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm">
                    </div>

                    {{-- End Date --}}
                    <div class="flex flex-col">
                        <label for="end_date" class="text-sm text-gray-600">End Date</label>
                        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                            class="block w-full sm:w-auto border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm">
                    </div>

                    {{-- Filter Button --}}
                    <div class="flex flex-col justify-end">
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-md shadow hover:bg-blue-700 transition">
                            Filter
                        </button>
                    </div>

                    {{-- Reset Button --}}
                    <div class="flex flex-col justify-end">
                        <a href="{{ route('tickets.index') }}"
                            class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-semibold rounded-md shadow hover:bg-gray-300 transition">
                            Reset
                        </a>
                    </div>

                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="w-full text-left">
                        <thead class="bg-gray-100 uppercase text-gray-600">
                            <tr>
                                <th class="px-3 py-2">#</th>
                                <th class="px-3 py-2">Customer</th>
                                @can('admin')
                                    <th class="px-3 py-2">Staff</th>
                                @endcan
                                {{-- <th class="px-3 py-2">Title</th> --}}
                                <th class="px-3 py-2">Status</th>
                                <th class="px-3 py-2">Priority</th>
                                <th class="px-3 py-2">Created At</th>
                                <th class="px-3 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @forelse ($tickets as $index => $ticket)
                                <tr class="border-b">
                                    <td class="px-3 py-2">{{ $tickets->firstItem() + $index }}</td>
                                    <td class="px-3 py-2">{{ $ticket->customer->name ?? '-' }}</td>
                                    @can('admin')
                                        <td class="px-3 py-2">{{ $ticket->staff->name ?? '-' }}</td>
                                    @endcan
                                    {{-- <td class="px-3 py-2">{{ Str::limit($ticket->title, 30) }}</td> --}}
                                    <td class="px-3 py-2">
                                        <span
                                            class="px-2 py-1 rounded
                                            @if ($ticket->status == 'open') bg-green-100 text-green-800
                                            @elseif($ticket->status == 'resolved') bg-blue-100 text-blue-800
                                            @elseif($ticket->status == 'in_progress') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2">
                                        <span
                                            class="px-2 py-1 rounded
                                            @if ($ticket->priority == 'high') bg-red-100 text-red-800
                                            @elseif($ticket->priority == 'medium') bg-yellow-100 text-yellow-800
                                            @else bg-green-100 text-green-800 @endif">
                                            {{ ucfirst($ticket->priority) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2">{{ $ticket->created_at->format('d M Y') }}</td>
                                    <td class="px-3 py-2 space-x-1">
                                        <a href="{{ route('tickets.show', $ticket) }}"><button
                                                class="px-4 py-2 text-sm bg-green-500 text-white font-semibold rounded hover:bg-green-600 transition">View</button></a>
                                        <a href="{{ route('tickets.edit', $ticket) }}"><button
                                                class="px-4 py-2 text-sm bg-blue-500 text-white font-semibold rounded hover:bg-blue-600 transition">Edit</button></a>
                                        <form action="{{ route('tickets.destroy', $ticket) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure?')"
                                                class="px-4 py-2 text-sm bg-red-500 text-white font-semibold rounded hover:bg-red-600 transition">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-3 py-2 text-center text-gray-500">No tickets found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if ($tickets->hasPages())
                        <div class="mt-6">
                            {{ $tickets->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
