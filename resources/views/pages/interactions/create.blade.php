<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Interaction') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Back Button --}}
            <div class="flex justify-end mb-4">
                <a href="{{ route('interactions.index') }}"
                    class="px-4 py-2 bg-white text-gray-700 text-sm font-semibold rounded-md shadow hover:bg-gray-100 transition">
                    Back
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('interactions.store') }}" method="POST" class="space-y-4"
                        x-data="{ loading: false }" x-on:submit="loading = true">
                        @csrf

                        {{-- Staff --}}
                        @can('admin')
                            <div>
                                <label for="staff_id" class="block text-sm font-medium text-gray-700">Staff <span
                                        class="text-red-500">*</span></label>
                                <select name="staff_id" id="staff_id"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                    <option value="">-- Select Staff --</option>
                                    @foreach ($staffs as $staff)
                                        <option value="{{ $staff->id }}"
                                            {{ old('staff_id') == $staff->id ? 'selected' : '' }}>
                                            {{ $staff->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('staff_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @else
                            <input type="hidden" name="staff_id" value="{{ Auth::id() }}">
                        @endcan

                        {{-- Customer --}}
                        <div>
                            <label for="customer_id" class="block text-sm font-medium text-gray-700">Customer <span
                                    class="text-red-500">*</span></label>
                            <select name="customer_id" id="customer_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                <option value="">-- Select Customer --</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Type --}}
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Interaction Type <span
                                    class="text-red-500">*</span></label>
                            <select name="type" id="type"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                <option value="">-- Select Type --</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Datetime --}}
                        <div>
                            <label for="datetime" class="block text-sm font-medium text-gray-700">Date & Time <span
                                    class="text-red-500">*</span></label>
                            <input type="datetime-local" name="datetime" id="datetime" value="{{ old('datetime') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            @error('datetime')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Notes --}}
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-md shadow hover:bg-blue-700 transition"
                                x-text="loading ? 'Saving...' : 'Save'" x-bind:disabled="loading">
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
