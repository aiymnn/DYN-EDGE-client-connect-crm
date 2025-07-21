<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Staffs') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Filters -->
            <div class="flex flex-col md:flex-row justify-between md:items-center mb-4 gap-2">
                <form method="GET" action="{{ route('users.index') }}"
                    class="flex flex-col sm:flex-row sm:items-center gap-2 w-full md:w-auto">

                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 w-full md:w-auto">

                        <!-- Entries -->
                        <div>
                            <select name="entries"
                                class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm">
                                <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10 entries
                                </option>
                                <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25 entries
                                </option>
                                <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50 entries
                                </option>
                            </select>
                        </div>

                        <!-- Name -->
                        <div>
                            <input type="text" name="name" placeholder="Search name" value="{{ request('name') }}"
                                class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm">
                        </div>

                        <!-- Email -->
                        <div>
                            <input type="text" name="email" placeholder="Search email"
                                value="{{ request('email') }}"
                                class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm">
                        </div>

                        <!-- Phone -->
                        <div>
                            <input type="text" name="phone" placeholder="Search phone"
                                value="{{ request('phone') }}"
                                class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm">
                        </div>

                        {{-- <!-- Role (optional) -->
                        <div>
                            <select name="role"
                                class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm">
                                <option value="">All Roles</option>
                                <option value="R01" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="R02" {{ request('role') == 'staff' ? 'selected' : '' }}>Staff
                                </option>
                            </select>
                        </div> --}}

                        <!-- Submit -->
                        <div>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded shadow hover:bg-blue-700 transition">
                                Filter
                            </button>
                        </div>

                        <!-- Reset -->
                        <div>
                            <a href="{{ route('users.index') }}"
                                class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-semibold rounded shadow hover:bg-gray-300 transition">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>

                <!-- New Staff -->
                <div>
                    <a href="{{ route('users.create') }}"
                        class="px-4 py-2 bg-white text-gray-700 text-sm font-semibold rounded shadow hover:bg-gray-100 transition">
                        New Staff
                    </a>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="w-full text-left">
                        <thead class="bg-gray-100 uppercase text-gray-600">
                            <tr>
                                <th class="px-3 py-2">#</th>
                                <th class="px-3 py-2">Name</th>
                                <th class="px-3 py-2">Email</th>
                                <th class="px-3 py-2">Phone</th>
                                <th class="px-3 py-2">Role</th>
                                <th class="px-3 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($staffs as $index => $staff)
                                <tr class="border-b">
                                    <td class="px-3 py-2">{{ $index + 1 }}</td>
                                    <td class="px-3 py-2">{{ $staff->name }}</td>
                                    <td class="px-3 py-2">{{ $staff->email }}</td>
                                    <td class="px-3 py-2">{{ $staff->phone }}</td>
                                    <td class="px-3 py-2 capitalize">
                                        {{ $staff->role === 'R01' ? 'Admin' : 'Staff' }}
                                    </td>
                                    <td class="px-3 py-2 space-x-1">
                                        <a href="{{ route('users.show', ['user' => $staff]) }}">
                                            <button
                                                class="px-4 py-2 bg-green-500 text-white text-sm font-semibold rounded hover:bg-green-600 transition">
                                                View
                                            </button>
                                        </a>
                                        @can('admin')
                                            <a href="{{ route('users.edit', ['user' => $staff]) }}">
                                                <button
                                                    class="px-4 py-2 bg-blue-500 text-white text-sm font-semibold rounded hover:bg-blue-600 transition">
                                                    Edit
                                                </button>
                                            </a>
                                            <form action="{{ route('users.destroy', ['user' => $staff]) }}" method="POST"
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

                    @if ($staffs->hasPages())
                        <div class="mt-6">
                            {{ $staffs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
