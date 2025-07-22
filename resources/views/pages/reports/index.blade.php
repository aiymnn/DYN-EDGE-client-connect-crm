<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Generate Report CSV') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @can('admin')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Export Staff Report</h3>

                    <form method="GET" action="{{ route('reports.staffs.export') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Register Date
                                    (From)</label>
                                <input type="date" name="start_date" id="start_date"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                    value="{{ request('start_date') }}">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">Register Date
                                    (To)</label>
                                <input type="date" name="end_date" id="end_date"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                    value="{{ request('end_date') }}">
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                    <option value="" {{ request('status') == '' ? 'selected' : '' }}>All</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div>
                                <button type="submit" name="format" value="csv"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-700 transition">
                                    Export Staff CSV
                                </button>
                            </div>
                            <div>
                                <button type="submit" name="format" value="pdf"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-700 transition">
                                    Export Staff PDF
                                </button>
                            </div>
                            <a href="{{ route('reports.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-300 transition">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mt-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Export Customer Report</h3>

                    <form method="GET" action="{{ route('reports.customers.export') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">
                                    Register Date (From)
                                </label>
                                <input type="date" name="start_date" id="start_date"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                    value="{{ request('start_date') }}">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">
                                    Register Date (To)
                                </label>
                                <input type="date" name="end_date" id="end_date"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                    value="{{ request('end_date') }}">
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                    <option value="" {{ request('status') == '' ? 'selected' : '' }}>All</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div>
                                <button type="submit" name="format" value="csv"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-700 transition">
                                    Export Customer CSV
                                </button>
                            </div>
                            {{-- Pdf --}}
                            <div>
                                <button type="submit" name="format" value="pdf"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-700 transition">
                                    Export Customer PDF
                                </button>
                            </div>
                            {{-- Reset Button --}}
                            <div>
                                <a href="{{ route('reports.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-300 transition">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            @endcan

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mt-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Export Ticket Report</h3>

                <form method="GET" action="{{ route('reports.tickets.export') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <div>
                            <label for="start_date_t" class="block text-sm font-medium text-gray-700">
                                Created Date (From)
                            </label>
                            <input type="date" name="start_date" id="start_date_t"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                value="{{ request('start_date') }}">
                        </div>

                        <div>
                            <label for="end_date_t" class="block text-sm font-medium text-gray-700">
                                Created Date (To)
                            </label>
                            <input type="date" name="end_date" id="end_date_t"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                value="{{ request('end_date') }}">
                        </div>

                        <div>
                            <label for="status_t" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status_t"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                <option value="" {{ request('status') == '' ? 'selected' : '' }}>All</option>
                                <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open
                                </option>
                                <option value="in_progress"
                                    {{ request('status') == 'in_progress' ? 'selected' : '' }}>
                                    In Progress</option>
                                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>
                                    Resolved</option>
                                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed
                                </option>
                            </select>
                        </div>

                        <div>
                            <label for="priority_t" class="block text-sm font-medium text-gray-700">Priority</label>
                            <select name="priority" id="priority_t"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                <option value="" {{ request('priority') == '' ? 'selected' : '' }}>All</option>
                                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low
                                </option>
                                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium
                                </option>
                                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High
                                </option>
                            </select>
                        </div>

                        <div>
                            <label for="name_t" class="block text-sm font-medium text-gray-700">Customer
                                Name</label>
                            <input type="text" name="name" id="name_t"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                placeholder="Customer Name" value="{{ request('name') }}">
                        </div>

                        <div>
                            <label for="staff_t" class="block text-sm font-medium text-gray-700">Staff Name</label>
                            <input type="text" name="staff" id="staff_t"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                placeholder="Staff Name" value="{{ request('staff') }}">
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div>
                            <button type="submit" name="format" value="csv"
                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-green-700 transition">
                                Export Ticket CSV
                            </button>
                        </div>
                        <div>
                            <button type="submit" name="format" value="pdf"
                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-green-700 transition">
                                Export Ticket PDF
                            </button>
                        </div>
                        {{-- Reset Button --}}
                        <div>
                            <a href="{{ route('reports.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-300 transition">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mt-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Export Interaction Report</h3>

                <form method="GET" action="{{ route('reports.interactions.export') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <div>
                            <label for="start_date_i" class="block text-sm font-medium text-gray-700">
                                Interaction Date (From)
                            </label>
                            <input type="date" name="start_date" id="start_date_i"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                value="{{ request('start_date') }}">
                        </div>

                        <div>
                            <label for="end_date_i" class="block text-sm font-medium text-gray-700">
                                Interaction Date (To)
                            </label>
                            <input type="date" name="end_date" id="end_date_i"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                value="{{ request('end_date') }}">
                        </div>

                        <div>
                            <label for="type_i" class="block text-sm font-medium text-gray-700">Type</label>
                            <select name="type" id="type_i"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                <option value="" {{ request('type') == '' ? 'selected' : '' }}>All</option>
                                <option value="call" {{ request('type') == 'call' ? 'selected' : '' }}>Call</option>
                                <option value="email" {{ request('type') == 'email' ? 'selected' : '' }}>Email
                                </option>
                                <option value="meeting" {{ request('type') == 'meeting' ? 'selected' : '' }}>Meeting
                                </option>
                                <option value="whatsapp" {{ request('type') == 'whatsapp' ? 'selected' : '' }}>
                                    WhatsApp</option>
                            </select>
                        </div>

                        <div>
                            <label for="name_i" class="block text-sm font-medium text-gray-700">Customer
                                Name</label>
                            <input type="text" name="name" id="name_i"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                placeholder="Customer Name" value="{{ request('name') }}">
                        </div>

                        <div>
                            <label for="staff_i" class="block text-sm font-medium text-gray-700">Staff Name</label>
                            <input type="text" name="staff" id="staff_i"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                placeholder="Staff Name" value="{{ request('staff') }}">
                        </div>

                    </div>

                    <div class="flex items-center gap-3">
                        <div>
                            <button type="submit" name="format" value="csv"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700 transition">
                                Export Interaction CSV
                            </button>
                        </div>
                        <div>
                            <button type="submit" name="format" value="pdf"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700 transition">
                                Export Interaction PDF
                            </button>
                        </div>
                        {{-- Reset Button --}}
                        <div>
                            <a href="{{ route('reports.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-300 transition">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
