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
    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Left side - Lyrics -->
                <div class="w-full lg:w-2/3">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4 sm:p-6">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900">Paroles</h3>
                            <div class="prose max-w-none whitespace-pre-line text-gray-700">
                                {!! $song->lyrics !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right side - Files and Comments -->
                <div class="w-full lg:w-1/3 space-y-6">
                    <!-- Files Section -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4 sm:p-6">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900">Fichiers</h3>
                            
                            @if($song->files->isEmpty())
                                <p class="text-gray-500 text-sm italic">Aucun fichier disponible</p>
                            @else
                                <div class="space-y-6">
                                    @foreach($song->files_grouped_by_pupitre as $pupitreName => $files)
                                        <div>
                                            <h4 class="text-md font-medium text-gray-900 mb-3">{{ $pupitreName }}</h4>
                                            <div class="space-y-3">
                                                @foreach($files as $file)
                                                    <div class="border border-gray-200 rounded-lg p-3 hover:bg-gray-50 transition duration-150">
                                                        <div class="flex items-center justify-between flex-wrap gap-2">
                                                            <div class="flex items-center space-x-3 min-w-0">
                                                                @if(str_starts_with($file->mime_type, 'audio/'))
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                                                    </svg>
                                                                @elseif(str_starts_with($file->mime_type, 'application/pdf'))
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                                                    </svg>
                                                                @else
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                                                    </svg>
                                                                @endif
                                                                <span class="text-sm font-medium text-gray-700 truncate">{{ $file->title }}</span>
                                                            </div>
                                                            <a href="{{ $file->download_link }}" 
                                                               download
                                                               class="inline-flex items-center px-3 py-1.5 bg-white border border-pink-500 rounded-md text-sm font-medium text-pink-500 hover:bg-pink-500 hover:text-white transition-colors duration-150">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                                </svg>
                                                                Télécharger
                                                            </a>
                                                        </div>
                                                        
                                                        @if(str_starts_with($file->mime_type, 'audio/'))
                                                            <div class="mt-3">
                                                                <audio controls class="w-full">
                                                                    <source src="{{ $file->download_link }}" type="{{ $file->mime_type }}">
                                                                    Votre navigateur ne supporte pas la lecture audio.
                                                                </audio>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Comments Section -->
                    @if($song->comment)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-4 sm:p-6">
                                <h3 class="text-lg font-semibold mb-4 text-gray-900">Commentaires</h3>
                                <div class="prose max-w-none text-sm text-gray-600 whitespace-pre-line">
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