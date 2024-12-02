<x-layout>
    <section class="bg-gray-50 dark:bg-gray-900 py-10 ml-72 mt-10">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">My Categories</h1>
                <a href="{{ route('instructor.categories.create') }}"
                   class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Add New Category
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 text-green-600 bg-green-100 border border-green-300 p-4 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($categories as $category)
                    <div class="bg-white rounded-lg shadow dark:bg-gray-800">
                        <div class="p-4">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white">{{ $category->name }}</h2>
                            <div class="flex mt-4">
                                <!-- Edit Button -->
                                <a href="{{ route('instructor.categories.edit', $category->id) }}"
                                   class="text-blue-500 hover:text-blue-600 mr-2">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('instructor.categories.destroy', $category->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center">
                        <p class="text-gray-500 dark:text-gray-400">No categories found. Start by adding a new category!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- SweetAlert2 for Delete Confirmation -->
    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you really want to delete this category?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
</x-layout>
