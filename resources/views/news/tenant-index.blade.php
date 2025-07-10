<x-app-layout>
<div class="max-w-7xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6">Latest News</h1>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($news as $item)
                <div class="bg-white rounded-xl shadow p-6 flex flex-col">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}"
                             alt="News image"
                             class="mb-4 w-full h-48 object-cover rounded-lg">
                    @endif
                    <div class="flex-1 flex flex-col">
                        <strong class="block text-xl mb-2">{{ $item->headline }}</strong>
                        <p class="text-gray-700 mb-3 flex-1">{{ $item->body }}</p>
                        <span class="text-xs text-gray-500 mt-auto">Posted {{ $item->created_at->format('j M Y') }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500 py-8">No news to show!</div>
            @endforelse
        </div>
    </div>
</x-app-layout>
