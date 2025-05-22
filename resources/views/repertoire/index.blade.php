<x-app-layout>
    <div class="wrapper">
        <div class="content max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl font-bold mb-8">Répertoire</h1>

            @foreach($seasons as $season)
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold mb-6">Saison : {{ $season->name }}</h2>

                    @if($season->songs->isNotEmpty())
                        <div class="columns-1 md:columns-2 gap-6">
                            <ul class="list-disc list-inside">
                                @foreach($season->songs as $song)
                                    <li class="break-inside-avoid-column mb-2">
                                        <span class="font-medium">{{ $song->title }}</span>
                                        @if($song->author)
                                            <span class="text-sm text-gray-600 ml-1">- {{ $song->author }}</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <p class="text-gray-500 italic">Aucune chanson dans cette saison.</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout> 