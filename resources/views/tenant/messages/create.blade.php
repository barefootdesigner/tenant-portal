<x-app-layout>
    <div class="max-w-xl mx-auto p-6 bg-white rounded shadow mt-6">
        <h1 class="text-2xl font-bold mb-4">New Maintenance Request</h1>

        <form action="{{ route('tenant.messages.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="subject" class="block font-medium mb-1">Subject</label>
                <input type="text" name="subject" id="subject" required
                       class="w-full border border-gray-300 rounded px-3 py-2"
                       value="{{ old('subject') }}">
                @error('subject')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="message" class="block font-medium mb-1">Details</label>
                <textarea name="message" id="message" rows="5" required
                          class="w-full border border-gray-300 rounded px-3 py-2">{{ old('message') }}</textarea>
                @error('message')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Submit Request
            </button>
        </form>
    </div>
</x-app-layout>
