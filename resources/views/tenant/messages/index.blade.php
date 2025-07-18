<x-app-layout>
<div class="max-w-7xl mx-auto py-8 px-4">


<div class="flex items-center mb-8">
    <x-heroicon-o-chat-bubble-left-right class="w-10 h-10 text-white mr-3 mb-3" />
    <h1 class="text-3xl font-bold text-white tracking-tight">Your Notifications</h1>
</div>


       @forelse($messages as $message)
    @include('tenant.messages._message', ['message' => $message])
@empty
    <p class="text-gray-500">No messages yet.</p>
@endforelse

    </div>

    <script>
    function hideMessage(id, el) {
        fetch("{{ url('/messages') }}/" + id + "/hide", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({})
        })
        .then(response => {
            if(response.ok) {
                // Puff away!
                window.dispatchEvent(new CustomEvent('message-hidden', { detail: { id } }));
            }
        });
    }
</script>

</x-app-layout>
