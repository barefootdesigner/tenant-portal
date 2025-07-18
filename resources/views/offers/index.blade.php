<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4">
<div class="flex items-center mb-8">
    <x-heroicon-o-gift class="w-10 h-10 text-white mr-3" />
    <h1 class="text-3xl font-bold text-white tracking-tight">Offers & Events</h1>
</div>


<form method="get" class="mb-6">
    <label for="category" class="mr-2 font-semibold">Filter by category:</label>
    <select name="category" id="category" onchange="this.form.submit()" class="border rounded p-1">
        <option value="">All categories</option>
        @foreach ($categories as $cat)
            <option value="{{ $cat }}" {{ ($category ?? '') === $cat ? 'selected' : '' }}>
                {{ ucfirst($cat) }}
            </option>
        @endforeach
    </select>
</form>



        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($offers as $item)
                <div class="bg-white rounded-xl shadow p-6 flex flex-col">
                    @if($item->image)
<a href="{{ route('offers.show', $item) }}">

<img src="{{ asset('storage/' . $item->image) }}"
                             alt="Offer image"
                             class="mb-4 w-full h-48 object-cover rounded-lg"></a>
                    @endif
                    <div class="flex-1 flex flex-col">
                        <strong class="block text-xl mb-2">{{ $item->headline }}</strong>
                        <p class="text-gray-700 mb-3 flex-1">{{ $item->body }}</p>
                        <div class="text-xs text-gray-500 mb-2">
                            {{ $item->start_date->format('j M Y') }} – {{ $item->end_date->format('j M Y') }}
                        </div>
                        @if($item->category)
                            <span class="inline-block bg-gray-200 rounded px-2 py-1 text-xs mb-2">{{ ucfirst($item->category) }}</span>
                        @endif
                        <span class="text-xs text-gray-500 mt-auto">Added {{ $item->created_at->format('j M Y') }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500 py-8">No current offers or events to show!</div>
            @endforelse
        </div>
    </div>
</x-app-layout>
