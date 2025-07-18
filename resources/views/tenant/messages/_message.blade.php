<div
    x-data="{ visible: true }"
    x-show="visible"
    x-transition:leave="transition duration-300 ease-in"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-75"
    @message-hidden.window="if ($event.detail.id === {{ $message->id }}) visible = false"
    @class([
        'relative',
        'bg-white',
        'rounded-xl',
        'shadow',
        'p-4',
        'mb-4',
        'border-l-4',
        'border-red-500' => $message->type === 'Issue',
        'border-yellow-500' => $message->type === 'Parcel',
        'border-blue-500' => $message->type === 'Notice',
        'border-gray-500' => $message->type === 'Alert',
    ])>

    <!-- Hide (puff) button -->
    <button
        type="button"
        @click.prevent="hideMessage({{ $message->id }}, $el)"
        class="absolute top-3 right-3 text-gray-300 hover:text-red-500 text-lg"
        title="Hide this message"
    >&times;</button>
    
    <!-- NEW: Icon + Content Flex Row -->
    <div class="flex items-start">
        <!-- ICON LEFT -->
       <span @class([
    'flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-full mr-4 mt-1', // <-- increased width/height from 10 to 12
    'bg-red-100 text-red-500' => $message->type === 'Issue',
    'bg-yellow-100 text-yellow-500' => $message->type === 'Parcel',
    'bg-blue-100 text-blue-500' => $message->type === 'Notice',
    'bg-gray-100 text-gray-500' => $message->type === 'Alert',
])>
    <span class="text-3xl">
        @switch($message->type)
            @case('Issue')
                ⚠️
                @break
            @case('Parcel')
                📦
                @break
            @case('Notice')
                📢
                @break
            @case('Alert')
                🔔
                @break
            @default
                📨
        @endswitch
    </span>
</span>


        <!-- ALL ORIGINAL CONTENT HERE -->
        <div class="flex-1 min-w-0">
            <div class="text-sm text-gray-500">
                {{ $message->created_at->format('d M Y H:i') }} —
                <span class="uppercase text-xs font-semibold">{{ $message->type }}</span>
            </div>
            @if ($message->subject)
                <h2 class="text-lg font-bold mt-1 inline-block">
                    <a href="{{ route('tenant.messages.show', $message->id) }}" class="hover:underline">
                        {{ $message->subject }}
                    </a>
                </h2>
                @php
                    $tenantId = auth()->id();
                    $unreadReplyExists = $message->replies->where('created_by', '!=', $tenantId)
                                                        ->filter(function($reply) use ($tenantId) {
                                                            return !$reply->readers->contains($tenantId);
                                                        })->isNotEmpty();
                @endphp

                @if (!in_array($message->id, $readIds) || $unreadReplyExists)
                    <span class="inline-block bg-green-500 text-white text-xs px-2 py-1 rounded ml-2 align-middle">NEW</span>
                @endif
            @endif

            @if ($message->message)
                <p class="text-sm text-gray-400 mt-1">
                    {{ \Illuminate\Support\Str::limit($message->message, 50) }}
                </p>
            @endif

            @if ($message->status)
                <div class="mt-2 inline-block bg-gray-100 text-xs px-2 py-1 rounded-full">
                    Status: {{ $message->status }}
                </div>
            @endif
        </div>
    </div>
</div>
