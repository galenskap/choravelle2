<section id="{{ $slug }}" class="banner wrapper relative">
    <div class="banner-image absolute inset-0">
        <img src="{{ Storage::url($content['image']) }}" alt="{{ $content['title'] }}" class="w-full h-full object-cover">
    </div>
    @if ($content['title'] || $content['text'])
    <div class="content relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-xl">
            <h2 class="h2 text-2xl"><span>{{ $content['title'] }}</span></h2>
            <div class="short-desc text-lg mt-4">
                {!! $content['text'] !!}
            </div>
            @if ($content['cta']['route'] && $content['cta']['label'])
                <div class="mt-6">
                    <a href="{{ route('page.show', ['slug' => $content['cta']['route']]) }}" class="inline-block px-6 py-3 text-lg font-semibold text-white bg-primary hover:shadow-md rounded-lg transition-all button">
                        {{ $content['cta']['label'] }}
                    </a>
                </div>
            @endif
        </div>
    </div>
    @endif
</section>
