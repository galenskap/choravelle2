@foreach($menuItems as $item)
    @if($item->children->count() > 0)
        <div 
            x-data="{ open: false }" 
            @mouseenter="if (window.innerWidth > 768) open = true" 
            @mouseleave="if (window.innerWidth > 768) open = false"
            class="relative sm:inline-flex"
        >
            <x-nav-link 
                href="{{ $item->url }}"
                :active="request()->url() === $item->url"
                @click.prevent="if (window.innerWidth <= 768) open = !open"
                class="inline-flex items-center"
            >
                {{ $item->title }}
                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </x-nav-link>

            <div 
                x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-1"
                class="absolute left-0 top-full mt-1 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                style="display: none;"
            >
                <div class="py-1">
                    @foreach($item->children as $child)
                        <a 
                            href="{{ $child->url }}"
                            class="childlink block px-4 py-2 text-sm transition-all hover:bg-gray-50 hover:text-primary {{ request()->url() === $child->url ? 'text-primary bg-gray-50' : 'text-gray-500' }}"
                        >
                            {{ $child->title }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <x-nav-link :href="$item->url" :active="request()->url() === $item->url">
            {{ $item->title }}
        </x-nav-link>
    @endif
@endforeach 