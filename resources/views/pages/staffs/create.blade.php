<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Staff') }}
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">New Staff</h3>

                    <form action="{{ route('users.store') }}" method="POST" class="space-y-4" x-data="{ loading: false }"
                        x-on:submit="loading = true">
                        @csrf
                        <div class="flex flex-col md:flex-row md:gap-4">
                            <!-- Name -->
                            <div class="mb-2 md:mb-0 md:flex-1">
                                <label for="name" class="block text-sm font-medium text-gray-700">
                                    Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-2 md:mb-0 md:flex-1">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email <span
                                        class="text-red-500">*</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row md:gap-4">
                            <!-- Phone -->
                            <div class="mb-2 md:mb-0 md:flex-1">
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Role -->
                            {{-- <div class="mb-2 md:mb-0 md:flex-1">
                                <label for="role" class="block text-sm font-medium text-gray-700">Role <span
                                        class="text-red-500">*</span></label>
                                <select name="role" id="role"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                    <option value="">Select Role</option>
                                    <option value="R01" {{ old('role') == 'R01' ? 'selected' : '' }}>Admin (R01)
                                    </option>
                                    <option value="R02" {{ old('role') == 'R02' ? 'selected' : '' }}>Staff (R02)
                                    </option>
                                </select>
                                @error('role')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div> --}}
                            <div class="mb-2 md:mb-0 md:flex-1">
                                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                                <input type="text" id="role_display" name="role_display"
                                    value="{{ old('role', 'R02') == 'R01' ? 'Admin (R01)' : 'Staff (R02)' }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 cursor-not-allowed"
                                    readonly disabled>
                                <input type="hidden" name="role" value="{{ old('role', 'R02') }}">
                            </div>

                        </div>

                        <div class="flex flex-col md:flex-row md:gap-4">
                            <!-- Password -->
                            <div class="mb-2 md:mb-0 md:flex-1">
                                <label for="password" class="block text-sm font-medium text-gray-700">Password <span
                                        class="text-red-500">*</span></label>
                                <input type="password" name="password" id="password"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-2 md:mb-0 md:flex-1">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                    Confirm Password <span class="text-red-500">*</span></label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-4 py-2 text-white bg-blue-600 text-sm font-semibold rounded-md shadow hover:bg-blue-700 transition"
                                x-text="loading ? 'Saving...' : 'Save'" x-bind:disabled="loading">
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
