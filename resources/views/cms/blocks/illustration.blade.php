<section id="{{ $slug }}" class="illustration wrapper">
    <div class="content max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-6">
        <div class="inner image-part @if($content['image_position'] === 'right') right @else left @endif">
            <img src="{{ Storage::url($content['image']) }}" alt="{{ $content['image_alt'] }}" class="content-image" width="700">
        </div>
        <div class="inner text-part">
            <h2 class="h2 text-2xl"><span>{{ $content['title'] }}</span></h2>
            <div class="short-desc text-xl editor">
                {!! $content['text'] !!}
            </div>
            @if ($content['cta']['route'] && $content['cta']['label'])
                <div class="flex justify-center cta">
                    <a href="{{ route('page.show', ['slug' => $content['cta']['route']]) }}" class="w-full md:w-auto px-6 py-3 button text-lg font-semibold text-white bg-primary hover:shadow-md rounded-lg transition-all">
                        {{ $content['cta']['label'] }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>
