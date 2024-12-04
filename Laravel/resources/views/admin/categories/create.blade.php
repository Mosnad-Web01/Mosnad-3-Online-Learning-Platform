<x-layout>
    <section class="bg-gray-50 dark:bg-gray-900 py-10 mt-10">
        <div class="container mx-auto px-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Create New Category</h1>

            <form action="{{ route('instructor.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category Name</label>
                    <input type="text" id="name" name="name" class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 dark:bg-gray-800 dark:text-white" required>
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <textarea id="description" name="description" rows="4" class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 dark:bg-gray-800 dark:text-white"></textarea>
                    @error('description')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category Image</label>
                    <input type="file" id="image" name="image" accept="image/*" class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 dark:bg-gray-800 dark:text-white">
                    @error('image')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Create Category
                </button>
            </form>
        </div>
    </section>
</x-layout>
