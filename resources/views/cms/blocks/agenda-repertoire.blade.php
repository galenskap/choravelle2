<section id="{{ $slug }}" class="agenda-repertoire wrapper">
    <div class="content max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="h2 text-2xl mb-8"><span>{{ $content['title'] }}</span></h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-16">
            <div class="agenda-section flex flex-col h-full">
                <h3 class="text-xl font-semibold mb-4">Prochains événements</h3>
                <div class="flex-1">
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
                        <div class="space-y-4">
                            @foreach($upcomingEvents as $event)
                                <article onclick="window.location='{{ route('event.show', $event) }}'" class="bg-white overflow-hidden shadow-sm rounded-lg cursor-pointer hover:shadow-md transition-shadow">
                                    <div class="flex gap-4 items-start">
                                        <div class="infos text-center w-24 bg-primary text-white p-3">
                                            <div class="font-bold">{{ \Carbon\Carbon::parse($event->date)->translatedFormat('d F') }}</div>
                                            <div class="text-sm opacity-90">{{ \Carbon\Carbon::parse($event->date)->translatedFormat('Y') }}</div>
                                            <div class="mt-1 text-xs opacity-90">{{ substr($event->time, 0, 5) }}</div>
                                        </div>
                                        
                                        <div class="flex-1 py-3 pr-3">
                                            <h4 class="font-medium">{{ $event->title }}</h4>
                                            <p class="text-sm text-gray-600 mt-1">{{ $event->location }}</p>
                                            @if($event->members_only)
                                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded whitespace-nowrap">Membres uniquement</span>
                                            @endif
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="text-gray-500 italic p-3">
                            Aucun événement à venir pour le moment.
                        </div>
                    @endif
                </div>

                <div class="mt-6">
                    <a href="{{ route('agenda') }}" class="block w-full text-center px-6 py-3 text-base font-semibold text-white bg-primary hover:bg-pink-700 rounded-lg transition-colors">
                        Voir tout l'agenda
                    </a>
                </div>
            </div>
            
            <div class="repertoire-section md:col-span-2 flex flex-col h-full">
                @php
                    $currentFolder = \App\Models\Folder::where('is_current', true)->first();
                    $songs = $currentFolder ? $currentFolder->songs : collect();
                @endphp
                <h3 class="text-xl font-semibold mb-4">Répertoire de la saison {{ $currentFolder->name }}</h3>
                <div class="flex-1">
                    @if($songs->isNotEmpty())
                        <div class="columns-1 md:columns-2 gap-6">
                            <ul class="list-disc list-inside">
                                @foreach($songs as $song)
                                    <li class="break-inside-avoid-column mb-1.5">
                                        <span class="font-medium">{{ $song->title }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="text-gray-500 italic p-3">
                            Aucune chanson sélectionnée pour l'affichage.
                        </div>
                    @endif
                </div>

                <div class="mt-6">
                    <a href="{{ route('repertoire') }}" class="block w-full text-center px-6 py-3 text-base font-semibold text-white bg-primary hover:bg-pink-700 rounded-lg transition-colors">
                        Voir tout le répertoire
                    </a>
                </div>
            </div>
        </div>
    </div>
</section> 