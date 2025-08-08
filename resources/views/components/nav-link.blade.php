@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'flex items-center p-3 text-gray-600 bg-blue-100 rounded-md mx-2'
            : 'flex items-center p-3 text-gray-800 rounded-md mx-2';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
