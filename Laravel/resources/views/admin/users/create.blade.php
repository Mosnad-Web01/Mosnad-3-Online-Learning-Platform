<x-layout>
    <section class="bg-gray-50 dark:bg-gray-900 py-10 px-4 sm:px-6 lg:px-8 mt-8">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">Create User</h1>
        <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="form-group">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name:</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <div class="form-group">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email:</label>
                <input type="email" name="email" id="email" class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <div class="form-group">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password:</label>
                <input type="password" name="password" id="password" class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password:</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <button type="submit" class="w-full sm:w-auto px-6 py-2 text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Create</button>
        </form>
    </section>
</x-layout>
