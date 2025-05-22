@foreach($menuItems as $item)
    <x-nav-link :href="$item->url" :active="request()->url() === $item->url">
        {{ $item->title }}
    </x-nav-link>
@endforeach 