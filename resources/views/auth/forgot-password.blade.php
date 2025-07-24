<x-guest-layout>
    <h2 class="text-center text-2xl font-bold text-gray-800 mb-2">Forgot Password</h2>
    <p class="text-center text-sm text-gray-500 mb-6">
        Enter your email and we will send you a password reset link.
    </p>

    @if (session('status'))
        <div class="mb-4 text-green-600 text-sm text-center">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5" x-data="{ loading: false }"
        x-on:submit="loading = true">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                placeholder="you@example.com" />
            @error('email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <button type="submit"
                class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                Email Password Reset Link
            </button>
        </div>
    </form>
</x-guest-layout>
