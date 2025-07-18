<x-app-layout>
<div class="max-w-7xl mx-auto py-8 px-4">
<div class="flex items-center mb-8">
    <x-heroicon-o-chart-bar class="w-10 h-10 text-white mr-3" />
    <h1 class="text-3xl font-bold text-white tracking-tight">Open Polls</h1>
</div>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 rounded text-green-800">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 rounded text-red-800">
                {{ session('error') }}
            </div>
        @endif

        @forelse($polls as $poll)
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="font-bold text-lg mb-3">{{ $poll->question }}</h2>
                <form action="{{ route('tenant.polls.vote', $poll) }}" method="POST" class="space-y-2">
                    @csrf
                    @foreach($poll->options as $key => $option)
                        <div>
                            <label class="inline-flex items-center">
                                <input type="radio" name="option_id" value="{{ $key }}" required class="form-radio">
                                <span class="ml-2">{{ is_array($option) ? $option['text'] : $option }}</span>
                            </label>
                        </div>
                    @endforeach
                    <button type="submit" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded">Vote</button>
                </form>
            </div>
        @empty
            <div class="p-6 bg-gray-100 rounded text-gray-600 text-center">
                No open polls available right now!
            </div>
        @endforelse
    </div>
</x-app-layout>
