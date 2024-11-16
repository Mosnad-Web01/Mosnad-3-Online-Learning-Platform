<x-layout>

<div class="bg-gray-100 min-h-screen">
    <!-- Hero Section -->
    <section class="text-center py-20 bg-blue-500 text-white">
        <h1 class="text-4xl font-bold mb-4">Welcome to Our Online Course Dashboard</h1>
        <p class="text-lg mb-6">Start learning and growing today. Access thousands of courses designed for all levels.</p>
        <a href="#courses" class="bg-white text-blue-500 px-6 py-2 rounded-full text-xl font-semibold hover:bg-gray-200 transition">Browse Courses</a>
    </section>

    <!-- Courses Section -->
    <section id="courses" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">Popular Courses</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Course Card 1 -->
                <div class="bg-gray-200 rounded-lg shadow-md overflow-hidden">
                    <img src="https://via.placeholder.com/400x250" alt="Course 1" class="w-full h-56 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800">Course 1</h3>
                        <p class="text-gray-600 mt-4">Learn the basics of web development with this beginner-friendly course.</p>
                        <a href="#" class="text-blue-500 mt-4 inline-block">Learn More</a>
                    </div>
                </div>

                <!-- Course Card 2 -->
                <div class="bg-gray-200 rounded-lg shadow-md overflow-hidden">
                    <img src="https://via.placeholder.com/400x250" alt="Course 2" class="w-full h-56 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800">Course 2</h3>
                        <p class="text-gray-600 mt-4">Dive into advanced concepts and enhance your skills in web development.</p>
                        <a href="#" class="text-blue-500 mt-4 inline-block">Learn More</a>
                    </div>
                </div>

                <!-- Course Card 3 -->
                <div class="bg-gray-200 rounded-lg shadow-md overflow-hidden">
                    <img src="https://via.placeholder.com/400x250" alt="Course 3" class="w-full h-56 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800">Course 3</h3>
                        <p class="text-gray-600 mt-4">Master frontend technologies and frameworks with this expert-level course.</p>
                        <a href="#" class="text-blue-500 mt-4 inline-block">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-blue-500 text-white text-center py-6">
        <p>&copy; 2024 Online Courses. All rights reserved.</p>
    </footer>
</div>

</x-layout>
