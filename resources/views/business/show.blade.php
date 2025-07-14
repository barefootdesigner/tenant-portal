<x-app-layout>
    <div class="max-w-2xl mx-auto py-8 px-4">
        <a href="{{ route('directory') }}" class="text-sm text-blue-600 hover:underline mb-4 inline-block">&larr; Back to Directory</a>
        <div class="bg-white rounded-xl shadow p-8 flex flex-col items-center mb-8">
            @if($business->logo)
                <img src="{{ asset('storage/' . $business->logo) }}" alt="{{ $business->name }} Logo" class="w-24 h-24 object-cover rounded-full mb-4 border shadow" />
            @else
                <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center text-4xl text-gray-400 mb-4">
                    {{ strtoupper(substr($business->name, 0, 1)) }}
                </div>
            @endif

            <h1 class="text-2xl font-bold mb-1">{{ $business->name }}</h1>
            @if($business->location)
                <div class="text-gray-500 mb-2">{{ $business->location }}</div>
            @endif
            @if($business->overview)
                <div class="text-gray-700 mb-4 text-center">{{ $business->overview }}</div>
            @endif
        </div>

        <div class="bg-gray-50 rounded-xl shadow-inner p-6">
            <h2 class="font-semibold text-lg mb-4">Tenants</h2>
            @forelse ($business->users as $user)
                <div class="flex items-center gap-3 mb-3">
                    @if($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" class="w-10 h-10 object-cover rounded-full border" alt="{{ $user->name }}">
                    @else
                        <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-xl text-gray-600 font-bold">
                            {{ strtoupper(substr($user->name,0,1)) }}
                        </div>
                    @endif
                    <div>
                        <div class="font-medium">{{ $user->name }}</div>
                        <div class="text-gray-500 text-xs">{{ $user->email }}</div>
                    </div>
                </div>
            @empty
                <div class="text-gray-400">No tenants assigned to this business.</div>
            @endforelse
        </div>
    </div>
</x-app-layout>
