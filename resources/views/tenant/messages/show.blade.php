<x-app-layout>
    <div class="max-w-2xl mx-auto mt-8 bg-white rounded-xl shadow p-6">
        <div class="text-sm text-gray-500 mb-2">
            {{ $message->created_at->format('d M Y H:i') }} —
            <span class="uppercase text-xs font-semibold">{{ $message->type }}</span>
        </div>

        <h1 class="text-2xl font-bold mb-2">{{ $message->subject ?? 'No subject' }}</h1>

        <div class="prose mb-4">
            {{ $message->message }}
        </div>

        @if ($message->status)
            <div class="mb-4 inline-block bg-gray-100 text-xs px-2 py-1 rounded-full">
                Status: {{ $message->status }}
            </div>
        @endif

        {{-- Replies --}}
        @if($message->replies && $message->replies->count())
            <div class="mt-6 border-t pt-4">
                <h2 class="font-semibold text-lg mb-2">Replies</h2>
                <div class="space-y-3">
                    @foreach($message->replies as $reply)
                        <div class="bg-gray-50 rounded p-3">
                            <span class="text-xs text-gray-500">
                                {{ $reply->created_at->format('d M Y H:i') }} —
                                <span class="font-semibold">{{ $reply->created_by ? 'Admin' : 'You' }}</span>
                            </span>
                            <div class="mt-1 text-gray-700">{{ $reply->message }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Reply form --}}
        @if ($message->replies_allowed)
            <form action="{{ route('messages.reply', $message) }}" method="POST" class="mt-6">
                @csrf
                <textarea name="message" rows="3" class="w-full border-gray-300 rounded" placeholder="Write a reply..."></textarea>
                <button type="submit" class="mt-2 bg-blue-600 text-white text-sm px-4 py-2 rounded">
                    Send Reply
                </button>
            </form>
        @else
            <div class="mt-6 text-xs text-gray-400 italic">
                Replies are not allowed for this message.
            </div>
        @endif

        <div class="mt-6">
            <a href="{{ route('tenant.messages.index') }}" class="text-blue-600 hover:underline">&larr; Back to messages</a>
        </div>
    </div>
</x-app-layout>
