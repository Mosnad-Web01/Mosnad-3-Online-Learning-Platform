<x-base>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-4 py-6 mx-auto md:h-screen lg:py-0 sm:px-2">
            <a href="#" class="flex items-center mb-6 text-lg sm:text-xl font-semibold text-gray-900 dark:text-white">
                <dev class="w-6 h-6 sm:w-8 sm:h-8 mr-2">
                    <x-logo href="/" showText="true" />
                </dev>
            </a>
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-sm md:max-w-md xl:max-w-lg xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-4 sm:p-6 space-y-4 md:space-y-6">
                    <h1 class="text-lg sm:text-xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white">
                        Create an account
                    </h1>

                    @if(session('success'))
                        <div class="alert alert-success text-xs sm:text-sm">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger text-xs sm:text-sm">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="space-y-4 md:space-y-6" action="{{ route('signup.submit') }}" method="POST">
                        @csrf

                        <div>
                            <label for="name" class="block mb-2 text-xs sm:text-sm font-medium text-gray-900 dark:text-white">Your name</label>
                            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-xs sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="John Doe" required>
                        </div>

                        <div>
                            <label for="email" class="block mb-2 text-xs sm:text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-xs sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" required>
                        </div>

                        <div>
                            <label for="password" class="block mb-2 text-xs sm:text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-xs sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="••••••••" required>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block mb-2 text-xs sm:text-sm font-medium text-gray-900 dark:text-white">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-xs sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="••••••••" required>
                        </div>

                        <div>
                            <label for="role" class="block mb-2 text-xs sm:text-sm font-medium text-gray-900 dark:text-white">Select Role</label>
                            <select name="role" id="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-xs sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="instructor" selected>Instructor</option>
                            </select>
                        </div>

                        <div class="mt-4 flex justify-between">
                            <span class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white">Optional Information</span>
                            <button type="button" id="toggle-optional" class="text-xs sm:text-sm text-blue-600 hover:text-blue-700 dark:text-blue-500 dark:hover:text-blue-400">
                                <i class="fas fa-arrow-down"></i> Show Optional Fields
                            </button>
                        </div>

                        <div id="optional-fields" class="hidden space-y-4 mt-4">
                            <div>
                                <label for="full_name" class="block mb-2 text-xs sm:text-sm font-medium text-gray-900 dark:text-white">Full Name (Optional)</label>
                                <input type="text" name="full_name" id="full_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-xs sm:text-sm rounded-lg block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="John Doe">
                            </div>
                            <!-- Other optional fields here -->
                        </div>

                        <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs sm:text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('toggle-optional').addEventListener('click', function () {
            const optionalFields = document.getElementById('optional-fields');
            if (optionalFields.classList.contains('hidden')) {
                optionalFields.classList.remove('hidden');
                this.textContent = 'Hide Optional Fields';
            } else {
                optionalFields.classList.add('hidden');
                this.textContent = 'Show Optional Fields';
            }
        });
    </script>
</x-base>
