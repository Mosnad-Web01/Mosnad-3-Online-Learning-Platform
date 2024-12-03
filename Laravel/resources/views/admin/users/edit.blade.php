<x-layout-admin>

    <!-- Display User Information -->
    <div class="p-6 mb-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">User Information</h3>

        <form action="{{ route('users.update', $user->id) }}" method="POST" class="mt-4">
            @csrf
            @method('PUT')

            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                <!-- User Name -->
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                    <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ $user->name }}" required>
                </div>

                <!-- Suspension Status -->
                <div>
                    <label for="is_suspended" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Suspended</label>
                    <input type="checkbox" name="is_suspended" id="is_suspended" {{ $user->is_suspended ? 'checked' : '' }}>
                </div>

                <!-- Suspension Reason -->
                <div class="sm:col-span-2">
                    <label for="suspension_reason" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Suspension Reason</label>
                    <textarea name="suspension_reason" id="suspension_reason" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">{{ $user->suspension_reason }}</textarea>
                </div>

                <!-- Suspension Start Date (with default value today) -->
                <div>
                    <label for="suspension_start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Suspension Start Date</label>
                    <input type="date" name="suspension_start_date" id="suspension_start_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ old('suspension_start_date', now()->toDateString()) }}" required>
                </div>

                <!-- Suspension End Date -->
                <div>
                    <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Suspension End Date</label>
                    <input type="date" name="end_date" id="end_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ old('end_date', $user->suspension_end_date ? \Carbon\Carbon::parse($user->suspension_end_date)->toDateString() : '') }}" required>
                </div>

                <!-- Suspension Reason -->
                <div class="sm:col-span-2">
                    <label for="reason" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Reason</label>
                    <input type="text" name="reason" id="reason" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ old('reason', $user->suspension_reason) }}" required>
                </div>
            </div>

            <button type="submit" class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                Update User
            </button>
        </form>
    </div>

</x-layout-admin>
