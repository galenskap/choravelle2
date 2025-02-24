<section id="{{ $slug }}" class="agenda-repertoire wrapper">
    <div class="content max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="h2 text-2xl mb-8"><span>Saison actuelle</span></h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="agenda-section">
                <h3 class="text-xl font-semibold mb-4">{{ $content['title'] }}</h3>
                <div class="agenda-content">
                    @php
                        $agendaContent = trim(strip_tags($content['agenda']));
                    @endphp
                    
                    @if(!empty($agendaContent))
                        @php
                            $content = preg_replace('/<li>/i', '<li class="hover-item mb-3 p-3 bg-gray-50 rounded-lg">', $content['agenda']);
                        @endphp
                        {!! $content !!}
                    @else
                        <div class="text-gray-500 italic p-3">
                            Aucun événement à venir pour le moment.
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="repertoire-section">
                <h3 class="text-xl font-semibold mb-4">Répertoire du moment</h3>
                <div class="repertoire-list">
                    @php
                        $songs = \App\Models\Song::where('show_on_home', true)->orderBy('title')->get();
                    @endphp
                    
                    @if($songs->isNotEmpty())
                        @foreach($songs as $song)
                            <div class="hover-item mb-3 p-3 bg-gray-50 rounded-lg">
                                <h4 class="font-medium">{{ $song->title }}</h4>
                                @if($song->composer)
                                    <p class="text-sm text-gray-600">{{ $song->composer }}</p>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="text-gray-500 italic p-3">
                            Aucune chanson sélectionnée pour l'affichage.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section> 