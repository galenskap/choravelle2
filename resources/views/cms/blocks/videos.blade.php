@php
function getYoutubeId($url) {
    if (empty($url)) return null;
    
    $pattern = '/^(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/';
    preg_match($pattern, $url, $matches);
    return $matches[1] ?? null;
}
@endphp

<section id="{{ $slug }}" class="videos wrapper">
    <div class="content max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="h2 text-2xl mb-8"><span>{{ $content['title'] }}</span></h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($content['videos'] as $video)
                <div class="video-container">
                    <div class="aspect-w-16 aspect-h-9 mb-3">
                        <iframe 
                            src="https://www.youtube.com/embed/{{ getYoutubeId($video['url']) }}?autoplay=0&rel=0" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen
                            class="rounded-lg shadow-lg"
                        ></iframe>
                    </div>
                    <div class="text-left">{{ $video['title'] }}</div>
                </div>
            @endforeach
        </div>

        <div class="text-center md:text-right mt-8">
            <a 
                href="{{ $content['channel_url'] }}" 
                target="_blank" 
                rel="noopener noreferrer" 
                class="button w-full md:w-auto inline-block px-6 py-3 text-base font-semibold text-white bg-primary hover:shadow-md rounded-lg transition-all"
            >
                Plus de vidéos
            </a>
        </div>
    </div>
</section> 