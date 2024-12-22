<x-layout>
    <main class="bg-white dark:bg-gray-900 text-black dark:text-white min-h-screen w-full">

    <section class="bg-gray-50 dark:bg-gray-900 py-10 mt-10 ml-[6rem] flex items-center justify-start rtl:justify-end">
    <div class="flex items-center justify-start rtl:justify-end">
    <div class="min-h-screen flex flex-col">

           <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-4xl font-extrabold leading-tight tracking-tight text-gray-900 dark:text-white">
                    Instructor Dashboard
                </h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">
                    Manage your courses, students, and more.
                </p>
            </div>

            <!-- Actions -->
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Course Management -->
                <div class="bg-gray-100 p-6 rounded-lg shadow-md hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Course Management</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        Create, edit, and manage your courses.
                    </p>
                    <a href="{{ route('instructor.courses.index') }}" class="mt-4 inline-block text-primary-600 dark:text-primary-500 hover:underline">
                        Manage Courses
                    </a>
                </div>
                 <!-- Actions -->
                <!-- Course Management -->
                <div class="bg-gray-100 p-6 rounded-lg shadow-md hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Course Management</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        Create, edit, and manage your courses.
                    </p>
                    <a href="{{ route('instructor.courses.index') }}" class="mt-4 inline-block text-primary-600 dark:text-primary-500 hover:underline">
                        Manage Courses
                    </a>
                </div>
                <div class="bg-gray-100 p-6 rounded-lg shadow-md hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Course Management</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        Create, edit, and manage your courses.
                    </p>
                    <a href="{{ route('instructor.courses.index') }}" class="mt-4 inline-block text-primary-600 dark:text-primary-500 hover:underline">
                        Manage Courses
                    </a>
                </div>



            </main>
    </section>
</x-layout>
