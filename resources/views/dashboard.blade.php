<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
               
           
@php
    $user = Auth::user();
    $hour = now()->format('H');
    if ($hour < 12) {
        $greeting = 'Good morning';
    } elseif ($hour < 18) {
        $greeting = 'Good afternoon';
    } else {
        $greeting = 'Good evening';
    }
@endphp

<div class="flex items-center gap-4 p-6 text-gray-900 bg-white rounded-lg shadow">
    @if($user->profile_image)
        <img 
            src="{{ asset('storage/' . $user->profile_image) }}" 
            alt="Profile Image" 
            class="rounded-full object-cover w-16 h-16 border"
        >
    @else
        <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center text-2xl font-bold text-gray-500">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
    @endif
    <div>
        <span class="block text-lg font-semibold">{{ $greeting }}, {{ $user->name }}!</span>
        <span class="block text-sm text-gray-500">{{ $user->email }}</span>
    </div>
</div>



           

            </div>


            



 <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
    <!-- Latest News Card -->
    <div class="bg-white rounded-xl shadow p-6 flex flex-col">
        <h2 class="text-lg font-bold mb-2">Latest News</h2>

        @if($latestNews)
            @if($latestNews->image)
                <img src="{{ asset('storage/' . $latestNews->image) }}" alt="{{ $latestNews->title }}" class="w-full h-48 object-cover rounded mb-4">
            @endif

            <div class="mb-2 font-semibold">{{ $latestNews->title }}</div>
            <div class="text-gray-700 text-sm mb-4">{{ \Illuminate\Support\Str::limit($latestNews->body, 120) }}</div>
            <a href="{{ route('news.show', $latestNews) }}" class="text-blue-500 underline">Read more</a>
        @else
            <div>No news posted yet.</div>
        @endif
    </div>

    <!-- Latest Offer Card -->
    <div class="bg-white rounded-xl shadow p-6 flex flex-col">
        <h2 class="text-lg font-bold mb-2">Latest Offer</h2>

        @if($latestOffer)
            @if($latestOffer->image)
                <img src="{{ asset('storage/' . $latestOffer->image) }}" alt="{{ $latestOffer->title }}" class="w-full h-48 object-cover rounded mb-4">
            @endif

            <div class="mb-2 font-semibold">{{ $latestOffer->title }}</div>
            <div class="text-gray-700 text-sm mb-4">{{ \Illuminate\Support\Str::limit($latestOffer->description, 120) }}</div>
            <a href="{{ route('offers.show', $latestOffer) }}" class="text-blue-500 underline">See offer</a>
        @else
            <div>No offers at the moment.</div>
        @endif
    </div>
</div>







        </div>





    </div>


</x-app-layout>
