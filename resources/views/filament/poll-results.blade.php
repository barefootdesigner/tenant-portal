<div class="bg-gray-50 rounded-xl p-4 my-6 border">
    <h3 class="text-lg font-bold mb-4">Poll Results</h3>
    <ul>
        @php
            $totalVotes = $record->votes()->count();
            $options = is_array($record->options) ? $record->options : [];
        @endphp
        @foreach($options as $key => $option)
            @php
                $count = $record->votes()->where('option_id', $key)->count();
                $percent = $totalVotes ? round($count / $totalVotes * 100, 1) : 0;
            @endphp
            <li class="mb-2">
                <strong>{{ is_array($option) ? $option['text'] : $option }}</strong>
                <span class="ml-2 text-gray-600">({{ $count }} votes, {{ $percent }}%)</span>
                <div class="h-2 rounded bg-gray-200 mt-1">
                    <div class="h-2 rounded bg-blue-400" style="width: {{ $percent }}%"></div>
                </div>
            </li>
        @endforeach
    </ul>
    <div class="mt-3 text-xs text-gray-500">Total votes: {{ $totalVotes }}</div>
</div>
