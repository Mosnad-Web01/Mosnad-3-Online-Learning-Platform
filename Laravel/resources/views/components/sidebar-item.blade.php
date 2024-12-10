@props(['href', 'icon', 'text'])

<li>
    <a href="{{ $href }}" {{ $attributes->merge(['class' => 'flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700']) }}>
        <i class="fas fa-{{ $icon }}"></i>
        <span class="ms-3 hidden sm:block">{{ $text }}</span>
    </a>
</li>
