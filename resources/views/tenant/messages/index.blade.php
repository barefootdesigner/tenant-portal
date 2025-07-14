<x-app-layout>
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6">Your Notifications</h1>

       @forelse($messages as $message)
    @include('tenant.messages._message', ['message' => $message])
@empty
    <p class="text-gray-500">No messages yet.</p>
@endforelse

    </div>
</x-app-layout>
