<div @class([
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
    <div class="text-sm text-gray-500">
        {{ $message->created_at->format('d M Y H:i') }} —
        <span class="uppercase text-xs font-semibold">{{ $message->type }}</span>
    </div>
    @if ($message->subject)
        <h2 class="text-lg font-bold mt-1">{{ $message->subject }}</h2>
        <p class="text-xs text-red-700">Type: {{ $message->type }}</p>
    @endif
    <p class="mt-1 text-gray-700">{{ $message->message }}</p>

    @if ($message->status)
        <div class="mt-2 inline-block bg-gray-100 text-xs px-2 py-1 rounded-full">
            Status: {{ $message->status }}
        </div>
    @endif

    {{-- Show replies, recursively --}}
    @if($message->replies->count())
        <div class="mt-4 ml-4 border-l-2 border-gray-200 pl-4 space-y-2">
            @foreach($message->replies as $reply)
                @include('tenant.messages._message', ['message' => $reply])
            @endforeach
        </div>
    @endif

    {{-- Reply form under every message (tenant can reply to any) --}}
    <form action="{{ route('messages.reply', $message) }}" method="POST" class="mt-4 ml-4">
        @csrf
        <textarea name="message" rows="2" class="w-full border-gray-300 rounded" placeholder="Write a reply..."></textarea>
        <button type="submit" class="mt-2 inline-block bg-blue-600 text-white text-sm px-3 py-1 rounded">
            Send Reply
        </button>
    </form>
</div>
