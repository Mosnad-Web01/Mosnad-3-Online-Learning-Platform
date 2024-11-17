"use client";
import React, { useState, useEffect } from 'react';
import { useParams, useRouter } from 'next/navigation';
import { fetchCourseById } from '@/services/api'; 
import LessonItem from '@/components/LessonItem'; 
import { FaPlayCircle, FaArrowLeft } from 'react-icons/fa'; 

const LessonsPage = () => {
  const { id } = useParams();  // الحصول على معرف الكورس من الرابط
  const router = useRouter(); // استخدام useRouter للانتقال إلى صفحة الكورس
  const [course, setCourse] = useState(null);
  const [selectedLesson, setSelectedLesson] = useState(null); // حالة لتخزين الدرس المحدد

  useEffect(() => {
    const fetchLessons = async () => {
      try {
        const response = await fetchCourseById(id);
        setCourse(response.data);  // تعيين بيانات الدورة في حالة
      } catch (error) {
        console.error("Error fetching course lessons:", error);
      }
    };

    fetchLessons();
  }, [id]);

  if (!course) return <p>Loading lessons...</p>;  // عرض رسالة أثناء تحميل الدروس

  const handleLessonClick = (lesson) => {
    // إذا كان الدرس نفسه هو الذي تم النقر عليه سابقًا، نقوم بإلغاء تحديده (إغلاق التفاصيل)
    if (selectedLesson && selectedLesson.id === lesson.id) {
      setSelectedLesson(null);  // إلغاء تحديد الدرس
    } else {
      setSelectedLesson(lesson);  // تعيين الدرس المحدد
    }
  };

  return (
    <div className="bg-white dark:bg-gray-900 text-black dark:text-white min-h-screen w-full">
      <div className="w-full px-4 py-8">
        {/* زر العودة إلى صفحة الكورس */}
        <div className="mb-4">
          <button
            onClick={() => router.push(`/course-details/${id}`)} 
            className="flex items-center text-lg font-semibold text-blue-500 hover:text-blue-700"
          >
            <FaArrowLeft className="mr-2" />
            Back to Course
          </button>
        </div>

        <h1 className="text-3xl font-bold mb-6">{course.course_name} - Lessons</h1>

        {/* عرض قائمة الدروس */}
        <div className="mb-6">
          <h2 className="text-2xl font-semibold mb-4">Lessons List:</h2>
          <ul className="list-none p-0 space-y-4">
            {course.lessons && course.lessons.length > 0 ? (
              course.lessons.map((lesson) => (
                <li
                  key={lesson.id}
                  className="cursor-pointer flex items-center space-x-3 p-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg shadow-md transition-all duration-300 ease-in-out transform hover:scale-103"  // تقليل تأثير التكبير
                  onClick={() => handleLessonClick(lesson)} 
                >
                  <FaPlayCircle className="text-xl text-purple-600 dark:text-purple-400" />
                  <span className="text-lg font-medium">{lesson.title}</span>
                </li>
              ))
            ) : (
              <p>No lessons available for this course.</p>
            )}
          </ul>
        </div>

        {/* عرض تفاصيل الدرس عند النقر عليه */}
        {selectedLesson ? (
          <div>
            <LessonItem lesson={selectedLesson} />
          </div>
        ) : (
          <p>Please select a lesson to view details.</p>
        )}
      </div>
    </div>
  );
};

export default LessonsPage;
