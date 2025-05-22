<section id="{{ $slug }}" class="editor wrapper">
    <div class="content max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col gap-4 text-xl">
        @if ($content['title'])
        <h2 class="text-2xl font-bold mb-4">{{ $content['title'] }}</h2>
        @endif

        {!! $content['text'] !!}

        @if ($content['cta'])
            <div class="flex justify-center">
                <a href="{{ $content['cta']['route'] }}" class="w-full md:w-auto px-6 py-3 text-lg font-semibold text-white bg-pink-600 hover:bg-pink-700 rounded-lg transition-colors button">
                    {{ $content['cta']['label'] }}
                </a>
            </div>
        @endif
    </div>
</section>
