<!-- resources/views/components/button-link.blade.php -->

<a href="{{ $route }}"
   class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 flex items-center space-x-2">
    {{ $slot }}
</a>
