<section id="{{ $slug }}" class="banner wrapper">
    <div class="content max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-6">
        <div class="inner left">
            <h2 class="h2 text-2xl"><span>{{ $content['title'] }}</span></h2>
            <div class="short-desc text-xl">
                {!! $content['text'] !!}
            </div>
            @if (isset($content['cta']) && isset($content['cta']['route']))
                <a href="{{ route($content['cta']['route']) }}" class="button">{{ $content['cta']['label'] }}</a>
            @endif
        </div>
        <div class="inner right">
            <img src="{{ Storage::url($content['image']) }}" alt="{{ $content['title'] }}" width="700">
        </div>
    </div>
</section>
