<section id="{{ $slug }}" class="illustration wrapper">
    <div class="content">
        <h2 class="h2"><span>{{ $content['title'] }}</span></h2>
        <div class="inner @if($content['image_position'] === 'right') right @else left @endif">
            <img src="{{ Storage::url($content['image']) }}" alt="{{ $content['image_alt'] }}" class="content-image">
            <div class="editor">
                {!! $content['text'] !!}
            </div>
        </div>
        @if (isset($content['cta']) && isset($content['cta']['route']))
        <a href="{{ route($content['cta']['route']) }}" class="button">{{ $content['cta']['label'] }}</a>
        @endif
    </div>
</section>