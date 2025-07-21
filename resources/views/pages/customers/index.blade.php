<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Customers') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between md:items-center mb-4 gap-2">
                <form method="GET" action="{{ route('customers.index') }}"
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
                            <input type="text" name="name" placeholder="Search name"
                                class="block w-full sm:w-auto border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm"
                                value="{{ request('name') }}">
                        </div>

                        {{-- Search by Email --}}
                        <div>
                            <input type="text" name="email" placeholder="Search email"
                                class="block w-full sm:w-auto border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm"
                                value="{{ request('email') }}">
                        </div>

                        {{-- Search by Phone --}}
                        <div>
                            <input type="text" name="phone" placeholder="Search phone"
                                class="block w-full sm:w-auto border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm"
                                value="{{ request('phone') }}">
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
                            <a href="{{ route('customers.index') }}"
                                class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-semibold rounded-md shadow hover:bg-gray-300 transition">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>

                {{-- New Button --}}
                <div>
                    <a href="{{ route('customers.create') }}"
                        class="px-4 py-2 bg-white text-gray-700 text-sm font-semibold rounded-md shadow hover:bg-gray-100 transition">
                        New Customer
                    </a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="w-full text-left">
                        <thead class="bg-gray-100 uppercase text-gray-600">
                            <tr>
                                <th class="px-3 py-2">#</th>
                                <th class="px-3 py-2">Name</th>
                                {{-- <th class="px-3 py-2">ID Number</th> --}}
                                <th class="px-3 py-2">Email</th>
                                <th class="px-3 py-2">Phone</th>
                                {{-- <th class="px-3 py-2">Interactions</th> --}}
                                {{-- <th class="px-3 py-2">Tickets</th> --}}
                                <th class="px-3 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($customers as $index => $customer)
                                <tr class="border-b">
                                    <td class="px-3 py-2">{{ $index + 1 }}</td>
                                    <td class="px-3 py-2">{{ $customer->name }}</td>
                                    {{-- <td class="px-3 py-2">{{ $customer->id_number }}</td> --}}
                                    <td class="px-3 py-2">{{ $customer->email }}</td>
                                    <td class="px-3 py-2">{{ $customer->phone }}</td>
                                    {{-- <td class="px-3 py-2">{{ $customer->interactions_count ?? 0 }}</td> --}}
                                    {{-- <td class="px-3 py-2">{{ $customer->tickets_count ?? 0 }}</td> --}}
                                    <td class="px-3 py-2 space-x-1">
                                        <a href="{{ route('customers.show', $customer) }}"><button
                                                class="px-4 py-2 bg-green-500 text-white text-sm font-semibold rounded hover:bg-green-600 transition">View</button></a>
                                        @can('admin')
                                            <a href="{{ route('customers.edit', $customer) }}"><button
                                                    class="px-4 py-2 bg-blue-500 text-white text-sm font-semibold rounded hover:bg-blue-600 transition">Edit</button></a>
                                            <form action="{{ route('customers.destroy', $customer) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure?')"
                                                    class="px-4 py-2 bg-red-500 text-white text-sm font-semibold rounded hover:bg-red-600 transition">
                                                    Delete
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if ($customers->hasPages())
                        <div class="mt-6">
                            {{ $customers->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
