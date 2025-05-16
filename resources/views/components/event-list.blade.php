@props(['events', 'title', 'empty_message', 'back_link' => null])

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="p-6 text-gray-900">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">{{ $title }}</h1>
                @if($back_link)
                    <a href="{{ $back_link['url'] }}" class="text-blue-600 hover:text-blue-800">
                        ← {{ $back_link['text'] }}
                    </a>
                @endif
            </div>

            @forelse ($events as $event)
                <article class="mb-12 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex flex-col sm:flex-row sm:gap-8 items-start">
                        <div class="infos text-center w-full sm:w-32 bg-primary text-white p-4">
                            <div class="font-bold text-xl">{{ $event->date->translatedFormat('d F') }}</div>
                            <div class="opacity-90">{{ $event->date->translatedFormat('Y') }}</div>
                            <div class="mt-2 text-sm opacity-90">{{ $event->time }}</div>
                        </div>
                            
                        <div class="details flex-1 p-6">
                            <h2 class="text-xl font-bold">{{ $event->title }}</h2>

                            @if($event->members_only)
                                <span class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded">Membres uniquement</span>
                            @endif

                            <div class="mt-4">
                                <p class="address"><span class="font-bold">Adresse :</span> <span class="text-gray-600">{{ $event->location }}</span></p>
                            </div>

                            <div class="mt-4 event-description">
                                {!! $event->description !!}
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <p class="text-gray-500 text-center py-8">{{ $empty_message }}</p>
            @endforelse

            <div class="mt-8 flex justify-center">
                {{ $slot }}
            </div>
        </div>
    </div>
</div> 