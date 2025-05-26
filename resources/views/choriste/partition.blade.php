<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ $song->title }}
            @if($song->author)
                <span class="text-light text-base"> - {{ $song->author }}</span>
            @endif
        </h2>
    </x-slot>

    @section('content')
    <div class="py-6 song-page">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back button -->
            <div class="mb-6">
                <a href="{{ route('partitions') }}" 
                   class="back-button button inline-flex items-center px-4 py-2 bg-white border-2 border-gray-200 rounded-md text-base font-medium text-gray-700 transition-all duration-150 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 transition-transform group-hover:-translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Retour aux partitions
                </a>
            </div>

            <div class="lyrics flex flex-col lg:flex-row gap-8">
                <!-- Left side - Lyrics -->
                @if($song->lyrics)
                    <div class="w-full lg:w-3/5">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 sm:p-8">
                                <div class="prose max-w-none whitespace-pre-line">
                                    {!! $song->lyrics !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Right side - Files and Comments -->
                <div class="files-comments-sections w-full {{ $song->lyrics ? 'lg:w-2/5' : 'lg:w-full' }} space-y-8">
                    <!-- Files Section -->
                    <div class="files-section bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 sm:p-8">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xl font-semibold">Fichiers</h3>
                                <button
                                    id="playAllButton"
                                    class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-medium rounded-md hover:shadow-md transition-all duration-150"
                                    onclick="togglePlayAll()"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                    </svg>
                                    <span id="playAllButtonText">Tout lire</span>
                                </button>
                            </div>
                            
                            @if($song->files->isEmpty())
                                <p class="text-light text-sm italic">Aucun fichier disponible</p>
                            @else
                                <div class="space-y-8">
                                    @foreach($song->files_grouped_by_pupitre as $pupitreName => $files)
                                        <div>
                                            <div class="flex items-center gap-4 mb-4">
                                                <h4 class="text-sm font-medium text-light uppercase tracking-wide shrink-0">{{ $pupitreName }}</h4>
                                                <div class="h-px bg-gray-200 w-full"></div>
                                            </div>
                                            <div class="space-y-4">
                                                @foreach($files as $file)
                                                    <div class="bg-gray-50 border-2 border-gray-200 rounded-lg p-5 transition-all duration-150">
                                                        <div class="file flex items-center justify-between flex-wrap gap-3">
                                                            <div class="file-info flex items-center space-x-3 min-w-0">
                                                                @if(str_starts_with($file->mime_type, 'audio/'))
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                                                    </svg>
                                                                @elseif(str_starts_with($file->mime_type, 'application/pdf'))
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                                                    </svg>
                                                                @else
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0 text-gray-600" viewBox="0 0 20 20" fill="currentColor">
                                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                                                    </svg>
                                                                @endif
                                                                <span class="file-title text-base font-medium">{{ $file->title }}</span>
                                                            </div>
                                                            <a href="{{ $file->download_link }}" 
                                                               download
                                                               class="download-button button flex items-center px-4 py-2 bg-primary text-white text-base font-medium rounded-md hover:shadow-md transition-all duration-150">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                                </svg>
                                                                Télécharger
                                                            </a>
                                                        </div>
                                                        
                                                        @if(str_starts_with($file->mime_type, 'audio/'))
                                                            <div class="mt-5">
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
                        <div class="comments-section bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 sm:p-8">
                                <h3 class="text-lg font-semibold mb-6">Commentaires</h3>
                                <div class="prose prose-sm max-w-none text-light whitespace-pre-line">
                                    {!! $song->comment !!}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            let isPlaying = false;
            const audioElements = document.querySelectorAll('audio');
            const playButton = document.getElementById('playAllButton');
            const playButtonText = document.getElementById('playAllButtonText');

            window.togglePlayAll = function() {
                isPlaying = !isPlaying;
                
                if (isPlaying) {
                    playButtonText.textContent = 'Tout arrêter';
                    playButton.classList.remove('bg-primary');
                    playButton.classList.add('bg-gray-600');
                    audioElements.forEach(audio => {
                        audio.currentTime = 0; // Remet à zéro
                        audio.play();
                    });
                } else {
                    playButtonText.textContent = 'Tout lire';
                    playButton.classList.remove('bg-gray-600');
                    playButton.classList.add('bg-primary');
                    audioElements.forEach(audio => {
                        audio.pause();
                        audio.currentTime = 0;
                    });
                }
            };

            // Écouter la fin de chaque audio
            audioElements.forEach(audio => {
                // Ajouter les écouteurs pour le changement de style pendant la lecture
                audio.addEventListener('play', () => {
                    audio.closest('audio').classList.add('playing');
                });
                
                audio.addEventListener('pause', () => {
                    audio.closest('audio').classList.remove('playing');
                });

                audio.addEventListener('ended', () => {
                    audio.closest('audio').classList.remove('playing');
                    // Vérifier si tous les audios sont terminés
                    const allEnded = Array.from(audioElements).every(a => a.ended || a.paused);
                    if (allEnded && isPlaying) {
                        isPlaying = false;
                        playButtonText.textContent = 'Tout lire';
                        playButton.classList.remove('bg-gray-600');
                        playButton.classList.add('bg-primary');
                    }
                });
            });

            // Ne montrer le bouton que s'il y a des fichiers audio
            const hasAudioFiles = Array.from(audioElements).length > 0;
            if (!hasAudioFiles) {
                playButton.style.display = 'none';
            }
        });
    </script>
    @endsection
</x-app-layout>