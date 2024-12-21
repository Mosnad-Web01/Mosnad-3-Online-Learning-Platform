<x-layout>
<div class="container mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-6">Add Video for Lesson: {{ $lesson->name }}</h2>

    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('lessons.storeVideo', $lesson->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="video" class="block text-sm font-medium text-gray-700">Upload Video</label>
            <input type="file" name="video" id="video" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Upload</button>
    </form>
</div>
</x-layout>
