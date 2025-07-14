<x-app-layout>
    <div class="max-w-2xl mx-auto py-8 px-4">
<a href="{{ route('tenant.news') }}">Back to News</a>
        <div class="bg-white rounded-xl shadow p-8">
            @if($news->image)
                <img src="{{ asset('storage/' . $news->image) }}"
                     alt="News image"
                     class="mb-6 w-full max-h-64 object-cover rounded-lg">
            @endif
            <h1 class="text-2xl font-bold mb-2">{{ $news->headline }}</h1>
            <div class="text-xs text-gray-500 mb-4">Posted {{ $news->created_at->format('j M Y') }}</div>
            <div class="text-gray-700 leading-relaxed">{{ $news->body }}</div>
        </div>
    </div>
</x-app-layout>
