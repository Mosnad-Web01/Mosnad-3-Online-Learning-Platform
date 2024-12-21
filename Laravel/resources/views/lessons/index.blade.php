<x-homelayout>
    <main class="bg-white dark:bg-gray-900 text-black dark:text-white min-h-screen w-full">
        <div class="w-full px-4 py-8 grid grid-cols-12 gap-4 mt-8">
            <!-- عمود القائمة -->
            <aside class="col-span-4 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-lg p-4">
                <div class="mb-6">
                    <a href="{{ route('courses.show', $course->id) }}"
                       class="flex items-center text-lg font-semibold text-blue-500 hover:text-blue-700">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Course
                    </a>
                </div>

                <h2 class="text-xl font-bold mb-4">Lessons List</h2>
                <ul class="list-none space-y-4" id="lessons-list">
                    @forelse ($lessons as $lesson)
                    <li class="lesson-item cursor-pointer p-3 bg-white dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg shadow-md transition duration-300"
                    data-lesson="{{ json_encode($lesson) }}">
                    <div class="flex items-center">
                        <i class="fas fa-play-circle text-xl text-purple-600 dark:text-purple-400 mr-3"></i>
                        <span class="text-lg font-medium">{{ $lesson->title }}</span>
                        <!-- أيقونة إكمال الدرس -->
                        <button
                        class="ml-auto complete-lesson-btn"
                        data-lesson-id="{{ $lesson->id }}"
                        data-completed="{{ $lesson->completed }}">
                        <i class="fas fa-check-circle" style="color: {{ $lesson->completed ? 'green' : 'gray' }};"></i>
                    </button>


                    </div>
                </li>

                    @empty
                        <p>No lessons available for this course.</p>
                    @endforelse
                </ul>
            </aside>

            <!-- عمود المحتوى -->
            <section class="col-span-8 bg-white dark:bg-gray-900 rounded-lg shadow-lg p-4" id="lesson-details">
                <h2 class="text-2xl font-bold mb-4">Select a lesson to view details</h2>
                <div id="lesson-content" class="hidden">
                    <!-- يتم عرض محتوى الدرس هنا -->
                </div>
            </section>
        </div>
    </main>
    </x-homelayout>

    <!-- إضافة مكتبة SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const lessonsList = document.querySelectorAll('.lesson-item');
            const lessonContentContainer = document.getElementById('lesson-content');
            const lessonDetails = document.getElementById('lesson-details');
            const completeLessonBtns = document.querySelectorAll('.complete-lesson-btn');

            // تحديث الأيقونة بناءً على حالة اكتمال الدرس
            completeLessonBtns.forEach(btn => {
    btn.addEventListener('click', async (e) => {
        e.preventDefault();
        const lessonId = btn.getAttribute('data-lesson-id');
        const lessonTitle = btn.closest('li').querySelector('span').textContent;
        const courseId = {{ $course->id }}; // استخدم معرف الدورة

        // تحقق إذا كان الدرس قد اكتمل بالفعل
        if (btn.getAttribute('data-completed') === '1') {
            Swal.fire({
                title: 'You have already completed this lesson!',
                icon: 'info',
                confirmButtonText: 'Okay'
            });
            return;
        }

        // عرض نافذة SweetAlert للتأكيد
        const result = await Swal.fire({
            title: `Are you sure you finished "${lessonTitle}" with all its content?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, complete it!',
            cancelButtonText: 'No, cancel'
        });

        if (result.isConfirmed) {
            try {
                const response = await fetch(`/courses/${courseId}/lessons/${lessonId}/complete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                });

                const data = await response.json();
                alert(`Progress: ${data.progress}%`);

                // تحديث حالة الإيقونة بعد إتمام الدرس
                btn.querySelector('i').style.color = 'green';
                btn.setAttribute('data-completed', '1');  // تحديث قيمة الـ data-completed
            } catch (error) {
                console.error('Error completing lesson:', error);
            }
        }
    });
});

lessonsList.forEach(lessonItem => {
    lessonItem.addEventListener('click', () => {
        const lesson = JSON.parse(lessonItem.getAttribute('data-lesson'));

        // تحديث محتوى الدرس
        renderLessonDetails(lessonContentContainer, lesson);
        lessonContentContainer.classList.remove('hidden');

        // تحديث شريط العنوان (URL)
        const newUrl = `/courses/{{ $course->id }}/lessons/${lesson.id}`;
        history.pushState({ lessonId: lesson.id }, lesson.title, newUrl);
    });
});


            completeLessonBtns.forEach(btn => {
    btn.addEventListener('click', async (e) => {
        e.preventDefault();
        const lessonId = btn.getAttribute('data-lesson-id');
        const lessonTitle = btn.closest('li').querySelector('span').textContent;
        const courseId = {{ $course->id }}; // استخدم معرف الدورة

        // تحقق إذا كان الدرس قد اكتمل بالفعل
        if (btn.getAttribute('data-completed') === '1') {
            Swal.fire({
                title: 'You have already completed this lesson!',
                icon: 'info',
                confirmButtonText: 'Okay'
            });
            return;
        }

        // عرض نافذة SweetAlert للتأكيد
        const result = await Swal.fire({
            title: `Are you sure you finished "${lessonTitle}" with all its content?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, complete it!',
            cancelButtonText: 'No, cancel'
        });

        if (result.isConfirmed) {
            try {
                const response = await fetch(`/courses/${courseId}/lessons/${lessonId}/complete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                });

                const data = await response.json();
                alert(`Progress: ${data.progress}%`);

                // تحديث حالة الإيقونة بعد إتمام الدرس
                btn.querySelector('i').style.color = 'green';
                btn.setAttribute('data-completed', '1');

            } catch (error) {
                console.error('Error completing lesson:', error);
            }
        }
    });
});


            function renderLessonDetails(container, lesson) {
                container.innerHTML = '';

                const title = document.createElement('h2');
                title.textContent = lesson.title;
                title.className = 'text-xl font-bold mb-3';
                container.appendChild(title);

                const content = document.createElement('p');
                content.textContent = lesson.content || 'No content available';
                content.className = 'text-gray-700 dark:text-gray-300 mb-4';
                container.appendChild(content);

                if (lesson.video_url) {
                    const video = document.createElement('video');
                    video.controls = true;
                    video.src = lesson.video_url;
                    video.className = 'w-full mb-4';
                    container.appendChild(video);
                }

                if (lesson.images && lesson.images.length > 0) {
                    lesson.images.forEach(image => {
                        const img = document.createElement('img');
                        img.src = image;
                        img.alt = lesson.title;
                        img.className = 'w-full mb-4 rounded-lg';
                        container.appendChild(img);
                    });
                }

                if (lesson.files && lesson.files.length > 0) {
                    lesson.files.forEach(file => {
                        const fileLink = document.createElement('a');
                        fileLink.href = file;
                        fileLink.target = '_blank';
                        fileLink.textContent = 'Download File';
                        fileLink.className = 'block text-blue-500 hover:underline mb-2';
                        container.appendChild(fileLink);
                    });
                }
            }
        });
    </script>
