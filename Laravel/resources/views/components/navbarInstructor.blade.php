<nav class="bg-gray-800 text-white shadow-lg">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ route('instructor.dashboard') }}" class="text-xl font-bold">
            Instructor Dashboard
        </a>

        <!-- Navigation Links -->
        <ul class="flex space-x-6">
            <li>
                <a href="{{ route('instructor.courses.index') }}" class="hover:text-gray-300">
                    Manage Courses
                </a>
            </li>
            <li>
                <a href="{{ route('instructor.courses.create') }}" class="hover:text-gray-300">
                    Create Course
                </a>
            </li>
            <!-- إضافة روابط الدروس والطلاب والاستفسارات والمراجعات -->
            @if(isset($course))
            <a href="{{ route('instructor.lessons.index', ['courseId' => $course->id]) }}" class="hover:text-gray-300">
                Manage Lessons
            </a>

            @endif

            <li>
            Students
            </li>
            <li>
                    Answer Queries
            </li>
            <li>
                    Reviews & Feedback
            </li>
        </ul>

        <!-- Profile/Logout Dropdown -->
        <div class="relative">
            <button class="flex items-center focus:outline-none">
                <span class="mr-2">Hi, {{ Auth::user()->name }}</span>
                <img src="{{ Auth::user()->profile_photo_url }}" alt="Profile" class="w-8 h-8 rounded-full">
            </button>
            <ul class="absolute right-0 mt-2 bg-white text-gray-800 shadow-md rounded-lg py-2 w-48">
                <li>
                    PRO
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-200">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>