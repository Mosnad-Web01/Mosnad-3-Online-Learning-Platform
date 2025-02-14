<nav class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
      <!-- Logo Section -->
      <a href="/" class="flex items-center">
          <img id="logo-image" src="{{ asset('images/light_mood.svg') }}" alt="Logo" class="h-10 w-auto">
          <span class="ml-2 text-xl font-semibold text-gray-900 dark:text-white">TutorNet</span>
      </a>

      <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
          </svg>
      </button>

      <div class="hidden w-full md:block md:w-auto" id="navbar-default">
        <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
          <li>
            <a href="/" class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500" aria-current="page">Home</a>
          </li>
          <li>
            <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">About</a>
          </li>
          <li>
            <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Services</a>
          </li>
          <li>
            <a href="/contact" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Contact</a>
          </li>

          @auth
            <li>
              <span class="text-gray-900 dark:text-white">{{ Auth::user()->email }}</span>
            </li>
            <li>
              <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                  @csrf
                  <button type="submit" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                  Logout
                  </button>
              </form>
            </li>
          @else
            <li>
              <a href="/login" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Login</a>
            </li>
          @endauth

          <button id="theme-toggle" type="button" class="text-gray-900 dark:text-white">
              <i class="fas fa-moon"></i>
          </button>
        </ul>
      </div>
    </div>
  </nav>

  <script>
      // Theme and Logo Toggle Logic
      const themeToggle = document.getElementById('theme-toggle');
      const logoImage = document.getElementById('logo-image');

      // Check localStorage for saved theme
      if (localStorage.getItem('theme') === 'dark') {
          document.documentElement.classList.add('dark');
          logoImage.src = "{{ asset('images/dark_mood.svg') }}";
      } else {
          document.documentElement.classList.remove('dark');
          logoImage.src = "{{ asset('images/light_mood.svg') }}";
      }

      themeToggle.addEventListener('click', () => {
          // Toggle theme
          document.documentElement.classList.toggle('dark');

          // Update logo based on theme
          if (document.documentElement.classList.contains('dark')) {
              localStorage.setItem('theme', 'dark');
              logoImage.src = "{{ asset('images/dark_mood.svg') }}";
          } else {
              localStorage.setItem('theme', 'light');
              logoImage.src = "{{ asset('images/light_mood.svg') }}";
          }
      });
  </script>
