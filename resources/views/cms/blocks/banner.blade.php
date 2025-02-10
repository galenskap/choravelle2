<section id="{{ $slug }}" class="banner wrapper">
    <div id="bgvideo">
        <div class="squares">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="content">
        <div class="inner">
            <h2 class="h2"><span>{{ $content['title'] }}</span></h2>
            <div class="short-desc">
                {!! $content['text'] !!}
            </div>
            @if (isset($content['cta']) && isset($content['cta']['route']))
                <a href="{{ route($content['cta']['route']) }}" class="button">{{ $content['cta']['label'] }}</a>
            @endif
        </div>
    </div>
</section>