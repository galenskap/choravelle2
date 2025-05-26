@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-primary text-sm font-medium leading-5 text-primary focus:outline-none focus:border-primary-dark transition-all duration-150 ease-in-out'
            : 'inactive inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text focus:outline-none focus:text-gray-700 focus:border-gray-300 transition-all duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
