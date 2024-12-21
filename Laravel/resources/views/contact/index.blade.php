<x-base>

    <section class="text-gray-600 dark:text-gray-300 body-font bg-gray-100 dark:bg-gray-900 relative">
        <div class="container px-5 py-4 mx-auto flex sm:flex-nowrap flex-wrap">
            <div class="lg:w-2/3 md:w-1/2 bg-gray-300 dark:bg-gray-700 rounded-lg overflow-hidden sm:mr-10 p-10 flex items-end justify-start relative">
                <iframe width="100%" height="350" class="absolute inset-0" frameborder="0" title="map" marginheight="0" marginwidth="0" scrolling="no" src="https://maps.google.com/maps?width=100%&height=600&hl=en&q=Al%20Amal%20Microfinance%20Bank%2C%20Baghdad%20St%2C%20Sana%27a%2C%20Yemen&ie=UTF8&t=&z=14&iwloc=B&output=embed" style="filter: grayscale(1) contrast(1.2) opacity(0.4);"></iframe>
                <div class="bg-white dark:bg-gray-800 relative flex flex-wrap py-2 rounded shadow-md">
                    <div class="lg:w-1/2 px-6">
                        <h2 class="title-font font-semibold text-gray-900 dark:text-gray-300 tracking-widest text-xs">ADDRESS</h2>
                        <p class="mt-1">
                            Sana'a, Yemen - TutorNet is an innovative online learning platform.
                        </p>
                    </div>
                    <div class="lg:w-1/2 px-6 mt-4 lg:mt-0">
                        <h2 class="title-font font-semibold text-gray-900 dark:text-gray-300 tracking-widest text-xs">EMAIL</h2>
                        <a class="text-indigo-500 leading-relaxed">TutorNet@gemail.com</a>
                        <h2 class="title-font font-semibold text-gray-900 dark:text-gray-300 tracking-widest text-xs mt-4">PHONE</h2>
                        <p class="leading-relaxed">123-456-7890</p>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/3 md:w-1/2 bg-white dark:bg-gray-700 flex flex-col md:ml-auto w-full md:py-8 mt-8 md:mt-0">
                <h2 class="text-gray-900 dark:text-gray-300 text-lg mb-1 font-medium title-font">Feedback</h2>
                <p class="leading-relaxed mb-5 text-gray-600 dark:text-gray-400">
                    Your thoughts help us improve. Please take a moment to share your feedback.
                </p>
                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <div class="relative mb-4">
                        <label for="name" class="leading-7 text-sm text-gray-600 dark:text-gray-300">Name</label>
                        <input type="text" id="name" name="name" class="w-full bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded border border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" required value="{{ old('name') }}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="relative mb-4">
                        <label for="email" class="leading-7 text-sm text-gray-600 dark:text-gray-300">Email</label>
                        <input type="email" id="email" name="email" class="w-full bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded border border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" required value="{{ old('email') }}">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="relative mb-4">
                        <label for="message" class="leading-7 text-sm text-gray-600 dark:text-gray-300">Message</label>
                        <textarea id="message" name="message" class="w-full bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded border border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out" required>{{ old('message') }}</textarea>
                        @error('message')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">Submit</button>
                </form>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">
                    Join our educational platform to explore a wide range of courses designed to enhance your skills and knowledge. Let's grow together!
                </p>
            </div>
        </div>
    </section>

</x-base>

<script>
    
    // Check localStorage for saved theme
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }

</script>
