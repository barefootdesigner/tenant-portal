<x-app-layout>
    <div class="container max-w-lg mx-auto py-8">
        <h1 class="text-2xl font-bold mb-4">Add News</h1>
<form method="POST" action="{{ route('news.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="headline" class="block font-semibold">Headline</label>
                <input type="text" name="headline" id="headline" class="w-full border rounded p-2" required value="{{ old('headline') }}">
                @error('headline')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="body" class="block font-semibold">Body</label>
                <textarea name="body" id="body" class="w-full border rounded p-2" rows="5" required>{{ old('body') }}</textarea>
                @error('body')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <!-- (Optional: Add image upload later) -->

            <div class="mb-4">
        <label for="image" class="block font-semibold">Image</label>
        <input type="file" name="image" id="image" accept="image/*">
        @error('image')
            <div class="text-red-500 text-sm">{{ $message }}</div>
        @enderror
    </div>

            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
                <a href="{{ route('news.index') }}" class="ml-4 underline text-gray-600">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
