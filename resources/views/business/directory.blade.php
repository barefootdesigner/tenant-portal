<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6">Business Directory</h1>

<form method="GET" action="{{ route('directory') }}" class="mb-4">
    <input 
        type="text" 
        name="search" 
        placeholder="Search businesses..." 
        value="{{ request('search') }}"
        class="border rounded p-2"
    >
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
</form>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($businesses as $business)
                <a href="{{ route('directory.show', $business) }}" class="bg-white rounded-xl shadow p-6 flex flex-col hover:shadow-lg transition group">
                    @if($business->logo)
                        <img src="{{ asset('storage/' . $business->logo) }}"
                             alt="{{ $business->name }} Logo"
                             class="mb-4 w-full h-48 object-cover rounded-lg">
                    @else
                        <div class="mb-4 w-full h-48 rounded-lg bg-gray-200 flex items-center justify-center text-4xl text-gray-400">
                            {{ strtoupper(substr($business->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="flex-1 flex flex-col">
                        <strong class="block text-xl mb-2 group-hover:text-blue-700">{{ $business->name }}</strong>
                        @if($business->overview)
                            <p class="text-gray-700 mb-3 flex-1">{{ Str::limit($business->overview, 90) }}</p>
                        @endif
                        @if($business->location)
                            <span class="text-sm text-gray-500 mb-2">{{ $business->location }}</span>
                        @endif
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center text-gray-500 py-8">No businesses to show!</div>
            @endforelse
        </div>
    </div>
</x-app-layout>
