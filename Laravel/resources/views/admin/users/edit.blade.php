<x-layout>
    <section class="bg-gray-50 dark:bg-gray-900 py-10 px-4 sm:px-6 lg:px-8 mt-8">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">Edit User</h1>
        <form method="POST" action="{{ route('users.update', $user->id) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Name Field -->
            <div class="form-group">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name:</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500" required>
                @error('name')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Role Field -->
            <div class="form-group">
                <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role:</label>
                <select id="role" name="role" class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Student</option>
                    <option value="instructor" {{ $user->role == 'instructor' ? 'selected' : '' }}>Instructor</option>
                </select>
                @error('role')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Suspension Fields -->
            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    <input type="checkbox" name="is_suspended" class="mr-2 rounded border-gray-300 dark:border-gray-700 focus:ring-indigo-500" {{ $user->is_suspended ? 'checked' : '' }}>
                    Suspend User
                </label>
            </div>

            <div class="form-group">
                <label for="suspension_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Suspension Reason:</label>
                <textarea id="suspension_reason" name="suspension_reason" class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500">{{ old('suspension_reason', $user->suspension_reason) }}</textarea>
                @error('suspension_reason')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Suspension End Date:</label>
                <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $user->suspension_end_date ? $user->suspension_end_date->format('Y-m-d') : '') }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500">
                @error('end_date')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="w-full sm:w-auto px-6 py-2 text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Update User</button>
        </form>
    </section>
</x-layout>
