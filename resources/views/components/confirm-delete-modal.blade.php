@props([
    'action',
    'title' => 'Delete Confirmation',
    'message' => 'Are you sure you want to delete this item? This action cannot be undone.',
])

<div x-data="{ open: false }" x-cloak>
    <!-- Trigger -->
    <span @click="open = true">
        {{ $trigger }}
    </span>

    <!-- Modal -->
    <div x-show="open" x-transition.opacity.duration.300ms
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div @click.away="open = false" x-transition.scale.duration.300ms
            class="bg-white rounded-lg shadow-lg w-full max-w-sm p-6 mx-4">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">{{ $title }}</h2>
            <p class="text-gray-600 mb-4">{{ $message }}</p>

            <div class="flex justify-end space-x-2">
                <button @click="open = false" type="button"
                    class="px-4 py-1.5 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 text-sm">
                    Cancel
                </button>

                <form method="POST" action="{{ $action }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-1.5 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
