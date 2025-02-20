<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $song->title }}
            @if($song->author)
                <span class="text-gray-500 text-base"> - {{ $song->author }}</span>
            @endif
        </h2>
    </x-slot>

    @section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex gap-6">
                <!-- Left side - Lyrics (2/3) -->
                <div class="flex-grow w-2/3">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Paroles</h3>
                            <div class="whitespace-pre-line">
                                {!! $song->lyrics !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right side - Files and Comments (1/3) -->
                <div class="w-1/3">
                    <!-- Files Section -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Fichiers</h3>
                            <div class="space-y-4">
                                @forelse($song->files as $file)
                                    <div class="border rounded p-3">
                                        @if(str_starts_with($file->mime_type, 'audio/'))
                                            <div class="mb-2">
                                                <audio controls class="w-full">
                                                    <source src="{{ Storage::url($file->path) }}" type="{{ $file->mime_type }}">
                                                    Votre navigateur ne supporte pas la lecture audio.
                                                </audio>
                                            </div>
                                        @endif
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm">{{ $file->name }}</span>
                                            <a href="{{ Storage::url($file->path) }}" 
                                               download
                                               class="text-sm text-indigo-600 hover:text-indigo-900">
                                                Télécharger
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500 text-sm">Aucun fichier disponible</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Comments Section -->
                    @if($song->comment)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-4">Commentaires</h3>
                                <div class="text-sm text-gray-600 whitespace-pre-line">
                                    {!! $song->comment !!}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>