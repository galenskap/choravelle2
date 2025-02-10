<section id="{{ $slug }}" class="icons wrapper">
    <div class="content">
        <h2 class="h2">{{ $content['title'] }}</h2>
        <div class="items">
            @foreach ($content['icons'] as $icon)
            <div class="item">
                @if (isset($icon['icon']))
                    <div class="image">
                        <img src="{{ Storage::url($icon['icon']) }}" alt="{{ $icon['title'] }}" />
                    </div>
                @endif
                <div class="text infobulle">
                    {!! $icon['text'] !!}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>