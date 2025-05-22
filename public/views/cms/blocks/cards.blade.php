<section id="{{ $slug }}" class="cards wrapper">
    <div class="content">
        <h2 class="h2"><span>{{ $content['title'] }}</span></h2>
        <ul class="items">
            @foreach ($content['cards'] as $card)
            <li class="item">
                <h3 class="h3">{{ $card['title'] }}</h3>
                @if (isset($card['image']))
                    <div class="image">
                        <img src="{{ Storage::url($card['image']) }}" alt="" height="75" width="75" />
                    </div>
                @endif
                <div class="text">
                    {!! $card['text'] !!}
                </div>
                @if (isset($card['cta']) && isset($card['cta']['route']))
                    <a href="{{ route('page.show', $card['cta']['route']) }}" class="button">{{ $card['cta']['label'] }}</a>
                @endif
            </li>
            @endforeach
        </ul>
        @if (isset($content['cta']) && isset($content['cta']['route']))
            <a href="{{ route('page.show', $content['cta']['route']) }}" class="button">{{ $content['cta']['label'] }}</a>
        @endif
    </div>
</section>