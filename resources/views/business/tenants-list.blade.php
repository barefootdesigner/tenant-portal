@php
    $record = $getRecord();
    $users = $record ? $record->users : collect();
@endphp

@if ($record)




    <div class="space-y-2">
        @forelse ($users as $user)
            <div class="flex items-center gap-2">
                @if($user->profile_image)
                    <img src="{{ asset('storage/'.$user->profile_image) }}" width="32" height="32" class="rounded-full">
                @else
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-300 text-gray-600 font-bold">
                        {{ strtoupper(substr($user->name,0,1)) }}
                    </span>
                @endif
                <span class="font-medium">{{ $user->name }}</span>
                <span class="text-gray-500 text-sm">({{ $user->email }})</span>
            </div>
        @empty
            <span class="text-gray-400">No tenants assigned.</span>
        @endforelse
    </div>
@else
    <span class="text-gray-400">Save the business first to see assigned tenants.</span>
@endif
