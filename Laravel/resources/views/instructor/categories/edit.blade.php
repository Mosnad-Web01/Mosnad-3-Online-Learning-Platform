<x-layout>
    <section class="bg-gray-50 dark:bg-gray-900 py-10 ml-72 mt-10">
        <div class="container mx-auto px-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Edit Category</h1>

            <form action="{{ route('instructor.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 dark:bg-gray-800 dark:text-white" required>
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Update Category
                </button>
            </form>
        </div>
    </section>
</x-layout>
