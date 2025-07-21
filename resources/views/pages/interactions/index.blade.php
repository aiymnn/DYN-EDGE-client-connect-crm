<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Interactions') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between md:items-center mb-4 gap-2">
                <form method="GET" action="{{ route('interactions.index') }}"
                    class="flex flex-col sm:flex-row sm:items-center gap-2 w-full md:w-auto">

                    {{-- Filters --}}
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 w-full md:w-auto">

                        {{-- Entries --}}
                        <div>
                            <label for="entries" class="sr-only">Entries</label>
                            <select id="entries" name="entries"
                                class="block w-full sm:w-auto border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm">
                                <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10 entries
                                </option>
                                <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25 entries
                                </option>
                                <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50 entries
                                </option>
                            </select>
                        </div>

                        {{-- Search by Name --}}
                        <div>
                            <input type="text" name="name" placeholder="Search customer"
                                class="block w-full sm:w-auto border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm"
                                value="{{ request('name') }}">
                        </div>

                        {{-- Search by staff --}}
                        @can('admin')
                            <div>
                                <input type="text" name="staff" placeholder="Search staff"
                                    class="block w-full sm:w-auto border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm"
                                    value="{{ request('staff') }}">
                            </div>
                        @endcan

                        {{-- Search by type --}}
                        <div>
                            <select name="type" id="type"
                                class="block w-full sm:w-auto border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm">
                                <option value="">-- All Types --</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type }}"
                                        {{ request('type') == $type ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $type)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Search by date --}}
                        <div>
                            <input type="date" name="date" id="date" value="{{ request('date') }}"
                                class="block w-full sm:w-auto border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm">
                        </div>

                        {{-- Submit Button --}}
                        <div>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-md shadow hover:bg-blue-700 transition">
                                Filter
                            </button>
                        </div>

                        {{-- Reset Button --}}
                        <div>
                            <a href="{{ route('interactions.index') }}"
                                class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-semibold rounded-md shadow hover:bg-gray-300 transition">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>

                {{-- New Button --}}
                <div>
                    <a href="{{ route('interactions.create') }}"
                        class="px-4 py-2 bg-white text-gray-700 text-sm font-semibold rounded-md shadow hover:bg-gray-100 transition">
                        New Interaction
                    </a>
                </div>
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
                                <th class="px-3 py-2">Type</th>
                                <th class="px-3 py-2">Date & Time</th>
                                <th class="px-3 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @forelse ($interactions as $index => $interaction)
                                <tr class="border-b">
                                    <td class="px-3 py-2">{{ $index + 1 }}</td>
                                    <td class="px-3 py-2">{{ $interaction->customer->name ?? '-' }}</td>
                                    @can('admin')
                                        <td class="px-3 py-2">{{ $interaction->staff->name ?? '-' }}</td>
                                    @endcan
                                    <td class="px-3 py-2">{{ ucfirst($interaction->type) }}</td>
                                    <td class="px-3 py-2">
                                        {{ \Carbon\Carbon::parse($interaction->datetime)->format('d M Y, h:i A') }}
                                    </td>
                                    <td class="px-3 py-2 space-x-1">
                                        <a href="{{ route('interactions.show', $interaction) }}"><button
                                                class="px-4 py-2 bg-green-500 text-white text-sm font-semibold rounded hover:bg-green-600 transition">View</button></a>
                                        <a href="{{ route('interactions.edit', $interaction) }}"><button
                                                class="px-4 py-2 bg-blue-500 text-white text-sm font-semibold rounded hover:bg-blue-600 transition">Edit</button></a>
                                        <form action="{{ route('interactions.destroy', $interaction) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure?')"
                                                class="px-4 py-2 bg-red-500 text-white text-sm font-semibold rounded hover:bg-red-600 transition">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-3 py-2 text-center text-gray-500">No interactions
                                        found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if ($interactions->hasPages())
                        <div class="mt-6">
                            {{ $interactions->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
