<x-app-layout>
    <div class="wrapper">
        <div class="content max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl font-bold mb-8">Répertoire</h1>

            @foreach($seasons as $season)
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold mb-6">Saison : {{ $season->name }}</h2>

                    @if($season->songs->isNotEmpty())
                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($season->songs as $song)
                                <li class="hover-item p-4 bg-gray-50 rounded-lg transition-transform duration-200 ease-in-out hover:translate-x-1">
                                    <div class="font-medium">{{ $song->title }}</div>
                                    @if($song->composer)
                                        <div class="text-sm text-gray-600">{{ $song->composer }}</div>
                                    @endif
                                    @if($song->style)
                                        <div class="text-xs text-gray-500 mt-1">{{ $song->style }}</div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500 italic">Aucune chanson dans cette saison.</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout> 