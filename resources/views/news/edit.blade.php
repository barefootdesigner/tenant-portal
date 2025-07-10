<x-app-layout>
    <div class="container max-w-lg mx-auto py-8">
        <h1 class="text-2xl font-bold mb-4">Edit News</h1>
<form method="POST" action="{{ route('news.update', $news) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="headline" class="block font-semibold">Headline</label>
                <input type="text" name="headline" id="headline" class="w-full border rounded p-2" required value="{{ old('headline', $news->headline) }}">
                @error('headline')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="body" class="block font-semibold">Body</label>
                <textarea name="body" id="body" class="w-full border rounded p-2" rows="5" required>{{ old('body', $news->body) }}</textarea>
                @error('body')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>

@if($news->image)
    <div class="mb-4">
        <label class="block font-semibold">Current Image</label>
        <img src="{{ asset('storage/' . $news->image) }}" alt="Current news image" class="max-w-xs mb-2">
    </div>
@endif

            <div class="mb-4">
        <label for="image" class="block font-semibold">Image</label>
        <input type="file" name="image" id="image" accept="image/*">
        @error('image')
            <div class="text-red-500 text-sm">{{ $message }}</div>
        @enderror
    </div>

            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Changes</button>
                <a href="{{ route('news.index') }}" class="ml-4 underline text-gray-600">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
