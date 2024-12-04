<x-layout>
    <section class="bg-gray-50 dark:bg-gray-900 py-10 mt-10">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manage Users</h1>
                <a href="{{ route('admin.users.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Add New User
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 text-green-600 bg-green-100 border border-green-300 p-4 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto shadow-lg rounded-lg">
                <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg">
                    <thead>
                        <tr class="text-left border-b dark:border-gray-700">
                            <th class="py-3 px-4 text-sm font-semibold text-gray-900 dark:text-white">Name</th>
                            <th class="py-3 px-4 text-sm font-semibold text-gray-900 dark:text-white">Role</th>
                            <th class="py-3 px-4 text-sm font-semibold text-gray-900 dark:text-white">Email</th>
                            <th class="py-3 px-4 text-sm font-semibold text-gray-900 dark:text-white">Created At</th>
                            <th class="py-3 px-4 text-sm font-semibold text-gray-900 dark:text-white">Suspended</th>
                            <th class="py-3 px-4 text-sm font-semibold text-gray-900 dark:text-white">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-b dark:border-gray-700">
                                <td class="py-3 px-4 text-sm text-gray-900 dark:text-white">{{ $user->name }}</td>
                                <td class="py-3 px-4 text-sm text-gray-900 dark:text-white">{{ ucfirst($user->role) }}</td>
                                <td class="py-3 px-4 text-sm text-gray-900 dark:text-white">{{ $user->email }}</td>
                                <td class="py-3 px-4 text-sm text-gray-900 dark:text-white">{{ $user->created_at->format('Y-m-d') }}</td>
                                <td class="py-3 px-4 text-sm">
                                    <input type="checkbox" disabled {{ $user->is_suspended ? 'checked' : '' }} />
                                </td>
                                <td class="py-3 px-4 text-sm text-right">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-500 hover:text-blue-600 mr-2">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent form submission directly
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you really want to delete this user?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit the form if confirmed
                    }
                });
            });
        });
    </script>
</x-layout>
