"use client";
import React from 'react';
import Image from 'next/image';
import { useParams } from 'next/navigation';
import { FaStar, FaPlay } from 'react-icons/fa';
import mockData from '@/data/mockData';
import ScrollableCourseList from '@/components/ScrollableCourseList';

const CourseDetails = () => {
  const { id } = useParams();
  const course = mockData.courses.find((c) => c.id === id);
  const instructor = mockData.users.find(user => user.role === 'instructor' && user.id === course.instructorUserId);
  const courseRatings = mockData.ratings.filter((rating) => rating.courseId === id);

  // حساب متوسط التقييم
  const averageCourseRating = courseRatings.length
    ? courseRatings.reduce((total, rating) => total + rating.courseRating, 0) / courseRatings.length
    : 0;

  // عرض أيقونات التقييم
  const ratingStars = Array.from({ length: 5 }, (_, index) => (
    <FaStar key={index} className={`${index < averageCourseRating ? 'text-yellow-500' : 'text-gray-400'}`} />
  ));

  // التحقق من وجود الدورة والمدرب
  if (!course || !instructor) return <p>Course or instructor not found</p>;

  // جلب بيانات الدورات المرتبطة باستخدام معرفاتها في `relatedCourses`
  const relatedCourses = course.relatedCourses.map(relatedId => 
    mockData.courses.find(c => c.id === relatedId)
  ).filter(c => c); // إزالة أي قيم فارغة في حالة عدم العثور على الدورة المرتبطة

  return (
    <div className="bg-white dark:bg-gray-900 text-black dark:text-white min-h-screen w-full">
      <div className="w-full px-0 py-0">
        {/* Course Details Section */}
        <section className="bg-gray-100 dark:bg-gray-800 p-8 mt-0 rounded-lg shadow-lg">
          <div className="flex flex-col lg:flex-row">
            <div className="w-full lg:w-1/4 mb-8 lg:mb-0">
              <Image
                src={`/images/courses/${course.id}.jpg`}
                alt={course.title}
                width={300}
                height={450}
                className="rounded-lg shadow-lg"
                layout="responsive"
              />
            </div>
            <div className="w-full lg:w-3/4 lg:ml-8">
              <h1 className="text-3xl md:text-4xl font-bold mb-2">{course.title}</h1>
              <p className="text-md md:text-lg mb-4">Instructor: {instructor.name}</p>
              <p className="text-md md:text-lg mb-4">Start Date: {course.startDate}</p>
              <p className="text-md md:text-lg mb-4">End Date: {course.endDate}</p>
              <p className="text-md md:text-lg mb-4">Language: {course.language}</p>

              {/* Ratings */}
              <div className="flex items-center mt-4">
                {ratingStars}
                <span className="ml-2 text-sm">({averageCourseRating.toFixed(1)})</span>
              </div>
            </div>
          </div>
        </section>

        {/* Divider */}
        <hr className="my-8 border-t border-gray-300 dark:border-gray-700" />

        {/* Requirements Section */}
        <section className="my-6 p-4 bg-white dark:bg-gray-900 text-black dark:text-white">
          <h2 className="text-2xl font-semibold">Requirements</h2>
          <ul className="list-disc ml-6">
            {course.requirements.map((req, index) => (
              <li key={index} className="text-sm mt-2">{req}</li>
            ))}
          </ul>
        </section>

        <hr className="my-8 border-t border-gray-300 dark:border-gray-700" />

        {/* Learning Outcomes Section */}
        <section className="my-6 p-4 bg-white dark:bg-gray-900 text-black dark:text-white">
          <h2 className="text-2xl font-semibold">Learning Outcomes</h2>
          <ul className="list-disc ml-6">
            {course.learningOutcomes.map((outcome, index) => (
              <li key={index} className="text-sm mt-2">{outcome}</li>
            ))}
          </ul>
        </section>

        <hr className="my-8 border-t border-gray-300 dark:border-gray-700" />

        {/* Course Content Section */}
        <section className="my-6 p-4 bg-white dark:bg-gray-900 text-black dark:text-white">
          <h2 className="text-2xl font-semibold">Course Content</h2>
          <p className="text-sm mt-2">{course.content}</p>
        </section>

        <hr className="my-8 border-t border-gray-300 dark:border-gray-700" />

        {/* Related Courses */}
        <section className="my-6 p-4 bg-white dark:bg-gray-900 text-black dark:text-white">
          <h2 className="text-2xl font-semibold">Related Courses</h2>
          {/* تمرير الدورات المرتبطة الكاملة إلى `ScrollableCourseList` */}
          <ScrollableCourseList courses={relatedCourses} />
        </section>
      </div>
    </div>
  );
};

export default CourseDetails;
