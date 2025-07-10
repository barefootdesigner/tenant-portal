<x-app-layout>
    <div class="container">
        <h1>News</h1>
        <a href="{{ route('news.create') }}">Add News</a>
        <ul>
            @forelse($news as $item)
                <li class="mb-4">
                    @if($item->image)
    <img src="{{ asset('storage/' . $item->image) }}" alt="News image" class="max-w-xs mb-2">
@endif

                    <strong>{{ $item->headline }}</strong>
                    <p>{{ $item->body }}</p>
                    <a href="{{ route('news.edit', $item) }}" class="text-blue-600 underline mr-2">Edit</a>
                    <form action="{{ route('news.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Delete this news item?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 underline ml-2">Delete</button>
                    </form>
                </li>
            @empty
                <li>No news yet!</li>
            @endforelse
        </ul>
    </div>
</x-app-layout>
