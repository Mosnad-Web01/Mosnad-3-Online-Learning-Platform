@php
    $user = Auth::user();
    $role = $user ? $user->role : null;
@endphp

 <header class="row-start-1 row-end-2 col-span-2 bg-gray-100 dark:bg-gray-900 lg:col-span-1 lg:col-end-3 flex flex-col lg:flex-row">
>
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center rtl:space-x-reverse space-x-4">
                <div class="flex items-center justify-start rtl:justify-end">
                    <a href="/home" class="flex ms-2 md:me-24">
                        <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 me-3" alt="App Logo" />
                        <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white hidden sm:block">MyApp</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Dark Mode Toggle Icon -->
                    <button id="theme-toggle" type="button" class="text-gray-900 dark:text-white">
                        <i class="fas fa-moon"></i>
                    </button>

                    <!-- User Dropdown Menu -->
                    <div class="relative">
                        <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            <span class="sr-only text-gray-900 dark:text-white">Open user menu</span>
                            <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo">
                        </button>
                        <div id="dropdown-user" class="hidden z-10 w-44 bg-white rounded shadow dark:bg-gray-700">
                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button">
                                <li>
                                    <a href="/profile" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Profile</a>
                                </li>
                                <li>
                                    <a href="/settings" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full text-left">
                                            Logout
                                        </button>
                                    </form>

                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Mobile Menu Toggle -->
                    <button id="sidebar-toggle" class="text-gray-900 dark:text-white">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 bg-white border-r dark:bg-gray-800 dark:border-gray-700 text-gray-900 dark:text-white transition-transform duration-300 transform -translate-x-full sm:translate-x-0">
        <div class="h-full px-3 pb-4 overflow-y-auto">
            <ul class="space-y-2 font-medium">
                <!-- Common Links -->
                <li>
                    <a href="{{ route('home') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-tachometer-alt"></i>
                        <span class="ms-3 hidden sm:block">Dashboard</span>
                    </a>
                </li>

                <!-- Links for Admin -->
                @if ($role === 'admin')
                    <li>
                        <a href="/admin/dashboard" class="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-cogs"></i>
                            <span class="ms-3 hidden sm:block">Admin Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/categories" class="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-list-alt"></i>
                            <span class="ms-3 hidden sm:block">Manage Categories</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/courses" class="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-book"></i>
                            <span class="ms-3 hidden sm:block">Manage Courses</span>
                        </a>
                    </li>
                    <li>
                        @if (isset($courseId))
                            <a href="/admin/courses/{{ $courseId }}/lessons" class="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-bookmark"></i>
                                <span class="ms-3 hidden sm:block">Manage Lessons</span>
                            </a>
                        @else
                            <a href="/admin/courses" class="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-bookmark"></i>
                                <span class="ms-3 hidden sm:block">Select a Course to Manage Lessons</span>
                            </a>
                        @endif
                    </li>
                    <li>
                        <a href="/admin/users" class="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-users"></i>
                            <span class="ms-3 hidden sm:block">Manage users</span>
                        </a>
                    </li>
                @endif

                <!-- Links for Instructor -->
                @if ($role === 'instructor')
                    <li>
                        <a href="/instructor/dashboard" class="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span class="ms-3 hidden sm:block">Instructor Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="/instructor/courses" class="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-edit"></i>
                            <span class="ms-3 hidden sm:block">Manage Courses</span>
                        </a>
                    </li>
                    <li>
                        <a href="/instructor/students" class="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-users"></i>
                            <span class="ms-3 hidden sm:block">Manage Students</span>
                        </a>
                    </li>
                    <li>
                        <a href="/instructor/categories" class="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-tags"></i>
                            <span class="ms-3 hidden sm:block">Manage Categories</span>
                        </a>
                    </li>
                    <li>
                        @if (isset($courseId))
                            <a href="/instructor/courses/{{ $courseId }}/lessons" class="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-bookmark"></i>
                                <span class="ms-3 hidden sm:block">Manage Lessons</span>
                            </a>
                        @else
                            <a href="/instructor/courses" class="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-bookmark"></i>
                                <span class="ms-3 hidden sm:block">Select a Course to Manage Lessons</span>
                            </a>
                        @endif
                    </li>
                @endif

                <!-- Links for Guest -->
                @if (!$role)
                    <li>
                        <a href="/login" class="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-sign-in-alt"></i>
                            <span class="ms-3 hidden sm:block">Login</span>
                        </a>
                    </li>
                    <li>
                        <a href="/signup" class="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-user-plus"></i>
                            <span class="ms-3 hidden sm:block">Sign Up</span>
                        </a>
                    </li>
                @endif
               <!-- Logout Form for Authenticated Users -->
                @if ($role)
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="ms-3 hidden sm:block">Logout</span>
                        </button>
                    </form>
                </li>
                @endif
            </ul>
        </div>
    </aside>
</header>

<script>
    // Theme Toggle Logic
    const themeToggle = document.getElementById('theme-toggle');

    // Check localStorage for saved theme
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }

    themeToggle.addEventListener('click', () => {
        // Toggle theme
        document.documentElement.classList.toggle('dark');

        // Save the theme in localStorage
        if (document.documentElement.classList.contains('dark')) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
        }
    });

    // Sidebar Toggle Logic
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const logoSidebar = document.getElementById('logo-sidebar');
    sidebarToggle.addEventListener('click', () => {
        logoSidebar.classList.toggle('-translate-x-full');
    });
</script>
