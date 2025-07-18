<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4">
<div class="flex items-center mb-8">
    <x-heroicon-o-document class="w-10 h-10 text-white mr-3" />
    <h1 class="text-3xl font-bold text-white tracking-tight">Documents</h1>
</div>

        @if($documents->isEmpty())
            <p>No documents available.</p>
        @else
            <ul class="space-y-4">
                @foreach($documents as $document)
                    <li class="border rounded p-4 flex justify-between items-center">
                        <div>
                            <div class="font-semibold">{{ $document->title }}</div>
                            @if($document->description)
                                <div class="text-gray-600 text-sm">{{ $document->description }}</div>
                            @endif
                        </div>
                        <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="text-blue-600 underline">
                            View / Download
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</x-app-layout>
