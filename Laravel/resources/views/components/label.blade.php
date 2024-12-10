<!-- resources/views/components/label.blade.php -->
<label for="{{ $for ?? '' }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 {{ $attributes->get('class') }}">
    {{ $slot }}
</label>
