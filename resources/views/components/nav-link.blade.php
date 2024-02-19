@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-4 rounded-lg border-lp3i-100 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-lp3i-300 transition duration-150 ease-in-out'
            : 'w-auto inline-flex items-center px-1 pt-1 border-b-4 rounded-lg border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
