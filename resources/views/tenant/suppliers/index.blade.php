<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4">
<div class="flex items-center mb-8">
    <x-heroicon-o-wrench class="w-10 h-10 text-white mr-3" />
    <h1 class="text-3xl font-bold text-white tracking-tight">Recommended Suppliers</h1>
</div>

        <!-- Filter by category -->
        <form method="get" class="mb-6">
            <label for="category" class="mr-2 font-semibold">Filter by category:</label>
            <select name="category" id="category" onchange="this.form.submit()" class="border rounded p-1">
                <option value="">All categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ ($categoryId ?? '') == $cat->id ? 'selected' : '' }}>
                        {{ ucfirst($cat->name) }}
                    </option>
                @endforeach
            </select>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($suppliers as $supplier)
                <div class="bg-white rounded-xl shadow p-6 flex flex-col">
                    @if($supplier->logo_path)
                        <img src="{{ asset('storage/' . $supplier->logo_path) }}"
                             alt="{{ $supplier->name }}"
                             class="mb-4 w-full h-48 object-contain rounded-lg bg-gray-100">
                    @endif
                    <div class="flex-1 flex flex-col">
                        <strong class="block text-xl mb-2">{{ $supplier->name }}</strong>
                        <p class="text-gray-700 mb-3 flex-1">{{ $supplier->description }}</p>
                        @if($supplier->supplierCategory)
                            <span class="inline-block bg-gray-200 rounded px-2 py-1 text-xs mb-2">
                                {{ ucfirst($supplier->supplierCategory->name) }}
                            </span>
                        @endif
                        @if($supplier->website)
                            <a href="{{ $supplier->website }}" target="_blank" rel="noopener"
                               class="text-blue-600 text-xs hover:underline mb-2">
                                Visit Website
                            </a>
                        @endif
                        <span class="text-xs text-gray-500 mt-auto">
                            Added {{ $supplier->created_at->format('j M Y') }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500 py-8">
                    No recommended suppliers to show!
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
