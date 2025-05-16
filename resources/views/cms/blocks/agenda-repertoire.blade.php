<section id="{{ $slug }}" class="agenda-repertoire wrapper">
    <div class="content max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="h2 text-2xl mb-8"><span>{{ $content['title'] }}</span></h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="agenda-section">
                <h3 class="text-xl font-semibold mb-4">Prochains événements</h3>
                <div class="agenda-content">
                    @php
                        $query = \App\Models\Event::where('date', '>=', \Carbon\Carbon::today());
                        
                        if (!auth()->check()) {
                            $query->where('members_only', false);
                        }
                        
                        $upcomingEvents = $query->orderBy('date')
                            ->limit(3)
                            ->get();
                    @endphp

                    @if($upcomingEvents->isNotEmpty())
                        <ul>
                            @foreach($upcomingEvents as $event)
                                <li class="hover-item mb-3 p-3 bg-gray-50 rounded-lg transition-transform duration-200 ease-in-out hover:translate-x-1">
                                    <strong>{{ \Carbon\Carbon::parse($event->date)->isoFormat('D MMMM YYYY') }}</strong>, 
                                    {{ substr($event->time, 0, 5) }} : 
                                    {{ $event->title }} - <em>{{ $event->location }}</em>
                                    @if($event->details)
                                        ({{ $event->details }})
                                    @endif
                                    @if($event->members_only)
                                        <span class="text-sm text-amber-600">(Membres uniquement)</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-gray-500 italic p-3">
                            Aucun événement à venir pour le moment.
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="repertoire-section md:col-span-2">
                @php
                    $currentFolder = \App\Models\Folder::where('is_current', true)->first();
                    $songs = $currentFolder ? $currentFolder->songs : collect();
                @endphp
                <h3 class="text-xl font-semibold mb-4">Répertoire de la saison {{ $currentFolder->name }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    @if($songs->isNotEmpty())
                        @foreach($songs as $song)
                            <div class="hover-item p-3 bg-gray-50 rounded-lg transition-transform duration-200 ease-in-out hover:translate-x-1">
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