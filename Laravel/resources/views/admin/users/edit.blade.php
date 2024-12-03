<x-layout-admin>
    <!-- Display User Information -->
    <div class="p-6 mb-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">User Information</h3>

        <form action="{{ route('users.update', $user->id) }}" method="POST" class="mt-4" id="userForm">
            @csrf
            @method('PUT')

            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                <!-- User Name -->
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                    <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('name') border-red-500 @enderror" value="{{ old('name', $user->name) }}" required disabled>
                    @error('name')
                        <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                    @enderror
                </div>
 <!-- User Role -->
 <div>
                    <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                    <select name="role" id="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('role') border-red-500 @enderror" >
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="student" {{ old('role', $user->role) == 'student' ? 'selected' : '' }}>Student</option>
                        <option value="instructor" {{ old('role', $user->role) == 'instructor' ? 'selected' : '' }}>Instructor</option>
                    </select>
                    @error('role')
                        <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Suspension Status -->
                <div>
                    <label for="is_suspended" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Suspended</label>
                    <input type="hidden" name="is_suspended" value="false">
                    <input type="checkbox" name="is_suspended" id="is_suspended" value="true" {{ old('is_suspended', $user->is_suspended) ? 'checked' : '' }} onchange="toggleFields(this)">
                    @error('is_suspended')
                        <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Suspension Reason -->
                <div class="sm:col-span-2">
                    <label for="suspension_reason" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Suspension Reason</label>
                    <textarea name="suspension_reason" id="suspension_reason" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('suspension_reason') border-red-500 @enderror" disabled>{{ old('suspension_reason', $user->suspension_reason) }}</textarea>
                    @error('suspension_reason')
                        <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Suspension Start Date (with default value today) -->
                <div>
                    <label for="suspension_start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Suspension Start Date</label>
                    <input type="date" name="suspension_start_date" id="suspension_start_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('suspension_start_date') border-red-500 @enderror" value="{{ old('suspension_start_date', now()->toDateString()) }}" required disabled>
                    @error('suspension_start_date')
                        <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Suspension End Date -->
                <div>
                    <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Suspension End Date</label>
                    <input type="date" name="end_date" id="end_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('end_date') border-red-500 @enderror" value="{{ old('end_date', $user->suspension_end_date ? \Carbon\Carbon::parse($user->suspension_end_date)->toDateString() : '') }}" required disabled>
                    @error('end_date')
                        <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                Update User
            </button>
        </form>
    </div>

    <script>
        // Function to toggle fields' disabled state based on is_suspended checkbox
        function toggleFields(checkbox) {
            const isSuspended = checkbox.checked;
            
            // Enable or disable the fields based on suspension status
            document.getElementById('name').disabled = !isSuspended;
            document.getElementById('suspension_reason').disabled = !isSuspended;
            document.getElementById('suspension_start_date').disabled = !isSuspended;
            document.getElementById('end_date').disabled = !isSuspended;

            // Apply the light gray color for disabled fields
            if (!isSuspended) {
                document.getElementById('suspension_reason').style.backgroundColor = '#f5f5f5'; // Light gray
                document.getElementById('suspension_start_date').style.backgroundColor = '#f5f5f5'; // Light gray
                document.getElementById('end_date').style.backgroundColor = '#f5f5f5'; // Light gray
            } else {
                document.getElementById('suspension_reason').style.backgroundColor = ''; // Reset to original
                document.getElementById('suspension_start_date').style.backgroundColor = ''; // Reset to original
                document.getElementById('end_date').style.backgroundColor = ''; // Reset to original
            }

            // If is_suspended is false, clear the reason and date fields
            if (!isSuspended) {
                document.getElementById('suspension_reason').value = '';
                document.getElementById('suspension_start_date').value = '';
                document.getElementById('end_date').value = '';
            }
        }

        // Call the function on page load to set initial state
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('is_suspended');
            toggleFields(checkbox);
        });
    </script>
</x-layout-admin>
