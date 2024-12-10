<!-- resources/views/components/title.blade.php -->
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $title }}</h1>
    <x-button-link :route="$createRoute">
        Add New Course
    </x-button-link>
</div>
