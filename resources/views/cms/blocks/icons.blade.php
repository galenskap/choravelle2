<section id="{{ $slug }}" class="icons wrapper">
    <div class="content">
        <h2 class="h2 text-2xl">{{ $content['title'] }}</h2>
        <div class="icons-grid">
            @foreach ($content['icons'] as $icon)
            <div class="icon-item">
                @if (isset($icon['icon']))
                    <div class="icon-image">
                        <img src="{{ Storage::url($icon['icon']) }}" alt="{{ $icon['title'] }}" />
                    </div>
                @endif
                @if (isset($icon['text']))
                    <div class="icon-tooltip infobulle">
                        {!! $icon['text'] !!}
                    </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>