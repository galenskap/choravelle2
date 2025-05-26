<section id="{{ $slug }}" class="editor wrapper">
    <div class="content max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col gap-4 text-xl">
        @if ($content['title'])
        <h2 class="text-2xl font-bold mb-4">{{ $content['title'] }}</h2>
        @endif

        {!! $content['text'] !!}

        @if ($content['cta']['route'] && $content['cta']['label'])
            <div class="flex justify-center">
                <a href="{{ route('page.show', ['slug' => $content['cta']['route']]) }}" class="w-full md:w-auto px-6 py-3 text-lg font-semibold text-white bg-primary hover:shadow-md rounded-lg transition-all button">
                    {{ $content['cta']['label'] }}
                </a>
            </div>
        @endif
    </div>
</section>
