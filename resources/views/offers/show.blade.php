<x-app-layout>
    <div class="max-w-2xl mx-auto py-8 px-4">
<a href="{{ route('offers.index') }}">Back to Offers</a>
        <div class="bg-white rounded-xl shadow p-8">
            @if($offer->image)
                <img src="{{ asset('storage/' . $offer->image) }}"
                     alt="Offer image"
                     class="mb-6 w-full max-h-64 object-cover rounded-lg">
            @endif
            <h1 class="text-2xl font-bold mb-2">{{ $offer->title }}</h1>
            <div class="text-xs text-gray-500 mb-4">Valid from {{ $offer->start_date->format('j M Y') }} to {{ $offer->end_date->format('j M Y') }}</div>
            <div class="text-gray-700 leading-relaxed">{{ $offer->description }}</div>
        </div>
    </div>
</x-app-layout>
