@php
    $user = Auth::user();
    $role = $user ? $user->role : null;
@endphp

<header>
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <a href="/home" class="flex ms-2 md:me-24">
                        <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 me-3" alt="App Logo" />
                        <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white hidden sm:block">MyApp</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Dark Mode Toggle Icon -->
                    <button id="theme-toggle" type="button" class="text-gray-900 dark:text-white">
                        <i class="fas fa-moon"></i> <!-- Moon icon for dark mode -->
                    </button>
                    <div class="flex items-center ms-3">
                        <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            <span class="sr-only">Open user menu</span>
                            <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo">
                        </button>
                    </div>

                    <!-- Mobile Menu Toggle -->
                    <button id="sidebar-toggle" class="sm:hidden text-gray-900 dark:text-white">
                        <i class="fas fa-bars"></i> <!-- Bars icon for opening sidebar -->
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 bg-white border-r dark:bg-gray-800 dark:border-gray-700 transition-transform duration-300 transform -translate-x-full sm:translate-x-0">
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
                        <a href="/categories" class="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
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
            </ul>
        </div>
    </aside>
</header>

<script>
    // Dark Mode Toggle
    document.getElementById('theme-toggle').addEventListener('click', () => {
        document.documentElement.classList.toggle('dark');
        // Store preference in localStorage
        const isDarkMode = document.documentElement.classList.contains('dark');
        localStorage.setItem('darkMode', isDarkMode ? 'enabled' : 'disabled');
    });

    // Check and apply dark mode preference on page load
    if (localStorage.getItem('darkMode') === 'enabled') {
        document.documentElement.classList.add('dark');
    }

    // Toggle sidebar visibility for small screens
    const sidebar = document.getElementById('logo-sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
    });
</script>
