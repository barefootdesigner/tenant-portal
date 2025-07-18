<x-app-layout>

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

    $apiKey = env('WEATHER_API_KEY');
    $city = env('DEFAULT_CITY', 'Lisbon');
    $weather = null;

    if ($apiKey) {
        try {
            $response = \Illuminate\Support\Facades\Http::get("http://api.weatherapi.com/v1/current.json", [
                'key' => $apiKey,
                'q' => $city,
            ]);
            if ($response->successful()) {
                $weather = $response->json();
            }
        } catch (\Exception $e) {
            $weather = null;
        }
    }
@endphp

<div class="dashboard-hero">
    <div class="dashboard-overlay"></div>

    <div class="dashboard-hero-content">
        {{-- Left side: User profile + greeting --}}
        <div class="dashboard-card">
            <div class="flex items-center gap-4">
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
                    <span class="block text-lg font-semibold text-white">{{ $greeting }}, {{ $user->name }}!</span>
                    <span class="block text-sm text-white/80">{{ $user->email }}</span>
                </div>
            </div>
        </div>

        {{-- Right side: Weather info --}}
        <div class="dashboard-card text-white">
            <span class="uppercase text-sm tracking-wider text-white/80">Current STOK Weather</span>
            @if(isset($weather) && $weather)
                <div class="flex items-center gap-3 mt-2">
                    <img 
                        src="https:{{ $weather['current']['condition']['icon'] }}" 
                        alt="Weather Icon" 
                        class="w-10 h-10"
                    >
                    <div class="font-semibold">
                        {{ round($weather['current']['temp_c']) }}°C — {{ $weather['current']['condition']['text'] }}
                    </div>
                </div>
            @else
                <div class="text-red-300 mt-2 font-semibold text-sm">Unavailable</div>
            @endif
        </div>
    </div>
</div>



<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            
<div class="dashboard-test-outline">


<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 my-8">

    {{-- Messages --}}
    <div class="bg-white rounded-xl shadow p-6 flex flex-col items-start">
        <x-heroicon-o-chat-bubble-left-right class="w-10 h-10 text-blue-500 mb-3" />
        <h2 class="text-lg font-bold mb-2">Messages</h2>
        <div class="text-gray-700 text-sm mb-4">
            @if($newMessages->count())
                You have {{ $newMessages->count() }} new message{{ $newMessages->count() > 1 ? 's' : '' }}.
            @else
                No new messages.
            @endif
        </div>
        <a href="{{ route('tenant.messages.index') }}" class="text-blue-500 underline">View all messages</a>
    </div>

    {{-- News --}}
    <div class="bg-white rounded-xl shadow p-6 flex flex-col items-start">
        <x-heroicon-o-megaphone class="w-10 h-10 text-amber-500 mb-3" />
        <h2 class="text-lg font-bold mb-2">News & Announcements</h2>
        @if($latestNews)
            <div class="mb-2 font-semibold">{{ $latestNews->title }}</div>
            <div class="text-gray-700 text-sm mb-4">{{ \Illuminate\Support\Str::limit($latestNews->body, 80) }}</div>
<a href="{{ route('tenant.news') }}" class="text-blue-500 underline">View all news</a>
        @else
            <div>No news posted yet.</div>
        @endif
    </div>

    {{-- Polls --}}
    <div class="bg-white rounded-xl shadow p-6 flex flex-col items-start">
        <x-heroicon-o-chart-bar class="w-10 h-10 text-purple-500 mb-3" />
        <h2 class="text-lg font-bold mb-2">Polls</h2>
        <div class="text-gray-700 text-sm mb-4">
            <a href="{{ route('tenant.polls.index') }}" class="text-blue-500 underline">Vote in open polls</a>
        </div>
    </div>

    {{-- Offers & Events --}}
    <div class="bg-white rounded-xl shadow p-6 flex flex-col items-start">
        <x-heroicon-o-gift class="w-10 h-10 text-pink-500 mb-3" />
        <h2 class="text-lg font-bold mb-2">Offers & Events</h2>
        @if($latestOffer)
            <div class="mb-2 font-semibold">{{ $latestOffer->title }}</div>
            <div class="text-gray-700 text-sm mb-4">{{ \Illuminate\Support\Str::limit($latestOffer->description, 80) }}</div>
<a href="{{ route('offers.index') }}" class="text-blue-500 underline">View all offers & events</a>
        @else
            <div>No offers at the moment.</div>
        @endif
    </div>

    {{-- Documents --}}
    <div class="bg-white rounded-xl shadow p-6 flex flex-col items-start">
        <x-heroicon-o-document class="w-10 h-10 text-teal-500 mb-3" />
        <h2 class="text-lg font-bold mb-2">Documents</h2>
        <div class="text-gray-700 text-sm mb-4">Access building documents and forms.</div>
        <a href="{{ route('tenant.documents.index') }}" class="text-blue-500 underline">View documents</a>
    </div>

    {{-- Directory --}}
    <div class="bg-white rounded-xl shadow p-6 flex flex-col items-start">
        <x-heroicon-o-building-office class="w-10 h-10 text-gray-700 mb-3" />
        <h2 class="text-lg font-bold mb-2">Directory</h2>
        <div class="text-gray-700 text-sm mb-4">See all businesses and contacts in the building.</div>
        <a href="{{ route('directory') }}" class="text-blue-500 underline">View directory</a>
    </div>

    {{-- Recommended Suppliers --}}
    <div class="bg-white rounded-xl shadow p-6 flex flex-col items-start">
        <x-heroicon-o-wrench class="w-10 h-10 text-green-600 mb-3" />
        <h2 class="text-lg font-bold mb-2">Recommended Suppliers</h2>
        <div class="text-gray-700 text-sm mb-4">Find trusted local suppliers.</div>
        <a href="{{ route('tenant.suppliers') }}" class="text-blue-500 underline">See suppliers</a>
    </div>

    {{-- New Request / Maintenance --}}
    <div class="bg-white rounded-xl shadow p-6 flex flex-col items-start">
        <x-heroicon-o-bell-alert class="w-10 h-10 text-red-500 mb-3" />
        <h2 class="text-lg font-bold mb-2">New Request</h2>
        <div class="text-gray-700 text-sm mb-4">Log a maintenance issue or request help.</div>
        <a href="{{ route('tenant.messages.create') }}" class="text-blue-500 underline">Submit new request</a>
    </div>
</div>

</div>









































    </div>





</x-app-layout>
