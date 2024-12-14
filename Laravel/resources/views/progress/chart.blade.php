<x-layout>
    <div class="lg:ml-[4rem] mt-16 lg:mt-0 flex-grow w-full bg-gray-100 dark:bg-gray-900">
        <section class="bg-gray-50 dark:bg-gray-900 py-10 mt-10 ml-[6rem] flex items-center justify-start rtl:justify-end">
            <div class="flex items-center justify-start rtl:justify-end">
                <div class="min-h-screen flex flex-col">

                    <div class="container flex-grow mx-auto px-4">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Course Progress Statistics</h2>
                        <h3 class="mt-4 text-xl font-medium text-gray-700 dark:text-gray-300">
  xx

</h3>


                        <!-- رسم بياني: يظهر عدد الدروس المكتملة لكل طالب -->
                        <canvas id="progressChart" width="400" height="200"></canvas>

                        <h3 class="mt-4 text-xl font-medium text-gray-700 dark:text-gray-300">Progress Details:</h3>

                        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg mt-6">
                            <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-300">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white">Student Name</th>
                                        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white">Completed Lessons</th>
                                        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white">Total Time Spent (Minutes)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tbody>
    @foreach($lessonProgress as $progress)  <!-- استخدام lessonProgress مباشرة -->
        <tr class="border-b dark:border-gray-700">
            <td class="px-4 py-3">{{ $progress->user->name }}</td>
            <td class="px-4 py-3">{{ $progress->lesson->title }}</td>
            <td class="px-4 py-3">
                {{ secondsToHumanReadable($progress->total_duration_seconds ?? 0) }}
            </td>
        </tr>
    @endforeach
</tbody>




                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Links -->
                        <div class="mt-4">
                            {{ $lessonProgress->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </div>

    <script>
   const labels = @json(array_keys($lessonCounts)); // أسماء المستخدمين أو معرفاتهم
   const completedLessons = @json(array_values($lessonCounts)); // عدد الدروس المكتملة لكل مستخدم

   const ctx = document.getElementById('progressChart').getContext('2d');
   const progressChart = new Chart(ctx, {
       type: 'bar',
       data: {
           labels: labels, // أسماء الطلاب
           datasets: [{
               label: 'Completed Lessons',
               data: completedLessons, // عدد الدروس المكتملة
               backgroundColor: 'rgba(54, 162, 235, 0.2)',
               borderColor: 'rgba(54, 162, 235, 1)',
               borderWidth: 1
           }]
       },
       options: {
           scales: {
               y: {
                   beginAtZero: true
               }
           }
       }
   });
</script>


</x-layout>
