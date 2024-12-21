@php
$user = Auth::user();
$role = $user ? $user->role : null;
@endphp
@php
$sidebarLinks = [];

if ($role === 'Admin') {
$sidebarLinks = [
['href' => route('home'), 'icon' => 'tachometer-alt', 'text' => 'Dashboard'],
['href' => '/admin/dashboard', 'icon' => 'cogs', 'text' => 'Admin Dashboard'],
['href' => '/admin/categories', 'icon' => 'list-alt', 'text' => 'Manage Categories'],
['href' => '/admin/courses', 'icon' => 'book', 'text' => 'Manage Courses'],
['href' => '/admin/students', 'icon' => 'users', 'text' =>  'Manage Students'],
['href' => '/admin/users', 'icon' => 'users', 'text' => 'Manage Users'],
];
} elseif ($role === 'Instructor') {
$sidebarLinks = [
['href' => '/instructor/dashboard', 'icon' => 'chalkboard-teacher', 'text' => 'Instructor Dashboard'],
['href' => '/instructor/courses', 'icon' => 'edit', 'text' => 'Manage Courses'],
['href' => '/instructor/students', 'icon' => 'users', 'text' => 'Manage Students'],
['href' => '/instructor/categories', 'icon' => 'tags', 'text' => 'Manage Categories'],
['href' => isset($courseId) ? "/instructor/courses/$courseId/lessons" : '/instructor/courses', 'icon' => 'bookmark', 'text' => isset($courseId) ? 'Manage Lessons' : 'Select a Course to Manage Lessons'],
[
    'href' => '/instructor/reviews',
    'icon' => 'star', // أيقونة مناسبة للمراجعات
    'text' => 'Manage Reviews'
]

];
} elseif (!$role) {
$sidebarLinks = [
['href' => '/login', 'icon' => 'sign-in-alt', 'text' => 'Login'],
['href' => '/signup', 'icon' => 'user-plus', 'text' => 'Sign Up'],
];
}
@endphp
<header class="flex flex-col lg:grid lg:grid-rows-[auto_1fr] h-full">
    <!-- Navbar -->
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center">
                <!-- Logo Section -->
                <div class="flex items-center justify-start rtl:justify-end">
                    <!-- Logo Section -->
                    <x-logo
                        href="/"
                        showText="true" />


                </div>

                <!-- Right Section -->
                <div class="flex items-center space-x-4 ms-auto rtl:space-x-reverse">
                    <!-- Dark Mode Toggle Icon -->
                    <button id="theme-toggle" type="button" class="text-gray-900 dark:text-white">
                        <i class="fas fa-moon"></i>
                    </button>

                    <!-- User Dropdown Menu -->
                    @php
                    $user = Auth::user();
                    $role = $user ? $user->role : null;
                    @endphp

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

                                <!-- Dynamic Dropdown Links based on Role -->
                                @if ($role === 'Admin')
                                <li>
                                    <a href="/admin/dashboard" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Admin Dashboard</a>
                                </li>
                                <li>
                                    <a href="/admin/users" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Manage Users</a>
                                </li>
                                @elseif ($role === 'Instructor')
                                <li>
                                    <a href="/instructor/dashboard" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Instructor Dashboard</a>
                                </li>
                                <li>
                                    <a href="/instructor/courses" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Manage Courses</a>
                                </li>
                                @else
                                <li>
                                    <a href="/login" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Login</a>
                                </li>
                                <li>
                                    <a href="/signup" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sign Up</a>
                                </li>
                                @endif

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


    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-[10rem] h-screen pt-20 bg-white border-r dark:bg-gray-800 dark:border-gray-700 text-gray-900 dark:text-white transition-transform duration-300 transform -translate-x-full sm:translate-x-0">
        <ul class="space-y-2 font-medium">
            @foreach ($sidebarLinks as $link)
            <x-sidebar-item :href="$link['href']" :icon="$link['icon']" :text="$link['text']" />
            @endforeach

            <!-- Logout Link for Authenticated Users -->
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
