<div class="p-4 mb-2 bg-white rounded-xl shadow border-l-4 border-blue-400">
    <div class="flex justify-between items-center">
        <div>
            <span class="text-xs text-gray-400">
                {{ $message->created_at->format('d M Y H:i') }} — 
                {{ $message->created_by ? 'Admin' : 'Tenant' }}
            </span>
            <span class="text-xs ml-2 font-semibold uppercase">{{ $message->type }}</span>
        </div>
    </div>
    <div class="mt-1 text-gray-700">{{ $message->message }}</div>
    @if($message->status)
        <span class="inline-block bg-gray-100 text-xs px-2 py-1 rounded-full mt-2">
            Status: {{ $message->status }}
        </span>
    @endif

    {{-- Show replies recursively --}}
    @if($message->replies->count())
        <div class="ml-4 border-l-2 border-gray-200 pl-4 mt-3">
            @foreach($message->replies as $reply)
                @include('filament.admin.messages._thread', ['message' => $reply])
            @endforeach
        </div>
    @endif

    {{-- Admin reply form --}}
    <form action="{{ route('filament.admin.reply-to-message', $message) }}" method="POST" class="mt-2 ml-2">
        @csrf
        <textarea name="message" rows="2" class="w-full border-gray-300 rounded mb-1" placeholder="Write a reply as admin..."></textarea>
 <button type="submit" class="bg-blue-700 text-white text-xs px-3 py-1 rounded border border-black">
    Reply
</button>


    </form>
</div>
