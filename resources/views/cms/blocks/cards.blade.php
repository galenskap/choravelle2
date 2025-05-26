<section id="{{ $slug }}" class="cards wrapper">
    <div class="content max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="h2 text-2xl"><span>{{ $content['title'] }}</span></h2>
        <div class="items-wrapper">
            <ul class="items">
                @foreach ($content['cards'] as $card)
                <li class="item">
                    <h3 class="h3 text-xl font-bold">{{ $card['title'] }}</h3>
                    @if (isset($card['image']))
                        <div class="image">
                            <img src="{{ Storage::url($card['image']) }}" alt="" height="200" width="200" loading="lazy" />
                        </div>
                    @endif
                    <div class="text">
                        {!! $card['text'] !!}
                    </div>
                    @if (isset($card['cta']) && isset($card['cta']['route']))
                        <a href="{{ route('page.show', $card['cta']['route']) }}" class="button w-full md:w-auto px-6 py-3 text-lg font-semibold text-white bg-primary hover:shadow-md rounded-lg transition-all">
                            {{ $card['cta']['label'] }}
                        </a>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
        @if (isset($content['cta']) && isset($content['cta']['route']))
            <div class="flex justify-center mt-8">
                <a href="{{ route('page.show', $content['cta']['route']) }}" class="button w-full md:w-auto px-6 py-3 text-lg font-semibold text-white bg-primary hover:shadow-md rounded-lg transition-all">
                    {{ $content['cta']['label'] }}
                </a>
            </div>
        @endif
    </div>
</section>