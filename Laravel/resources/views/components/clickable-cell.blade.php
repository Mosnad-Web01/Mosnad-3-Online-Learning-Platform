@props(['route'])

<td {{ $attributes->merge(['class' => 'px-4 py-3 cursor-pointer']) }} onclick="window.location.href='{{ $route }}'">
    {{ $slot }}
</td>
