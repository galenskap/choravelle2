@auth
    <x-nav-link :href="route('trombinoscope')" :active="request()->routeIs('trombinoscope')">
        {{ __('Trombinoscope') }}
    </x-nav-link>
    <x-nav-link :href="route('partitions')" :active="request()->routeIs('partitions')">
        {{ __('Partitions') }}
    </x-nav-link>
@endauth 