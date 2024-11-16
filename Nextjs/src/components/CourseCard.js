import React from 'react';
import Image from 'next/image';
import Link from 'next/link';
import { FaStar } from 'react-icons/fa';
import mockData from '../data/mockData'; // استيراد البيانات

const CourseCard = ({ course }) => {
  // جلب التقييمات للدورة من جدول ratings
  const courseRatings = mockData.ratings
    .filter(rating => rating.courseId === course.id)
    .map(rating => rating.courseRating);

  // حساب متوسط تقييمات الدورة
  const averageCourseRating = courseRatings.length
    ? courseRatings.reduce((total, rating) => total + rating, 0) / courseRatings.length
    : 0;

  // جلب التقييمات الخاصة بالمدرب
  const instructorRatings = mockData.ratings
    .filter(rating => rating.instructorId === course.instructorId)
    .map(rating => rating.courseRating);

  const averageInstructorRating = instructorRatings.length
    ? instructorRatings.reduce((total, rating) => total + rating, 0) / instructorRatings.length
    : 0;

  // إنشاء النجوم بناءً على متوسط تقييم الدورة
  const ratingStars = Array.from({ length: 5 }, (_, index) => (
    <FaStar
      key={index}
      className={`text-yellow-400 ${index < averageCourseRating ? 'text-yellow-500' : 'text-gray-400'}`}
    />
  ));

  return (
    <div className="relative bg-gray-100 dark:bg-gray-700 text-black dark:text-white rounded-lg shadow-lg overflow-hidden w-full sm:w-[320px] lg:w-[350px] mx-4 mb-6">
      <Link href={`/course-details/${course.id}`} passHref>
      <Image
        src={`/images/courses/${course.id}.jpg`}
        alt={course.title} // Describe the course image
        width={500}
        height={300}
        className="w-full h-[200px] object-cover"
      />
      </Link>

      <div className="p-4">
        <h3 className="text-lg font-semibold">{course.title}</h3>
        <p className="text-sm text-gray-600 dark:text-gray-400">{course.description}</p>

        <div className="flex items-center mt-2">
          {ratingStars}
          <span className="ml-2 text-sm text-gray-600 dark:text-gray-400">
            ({averageCourseRating.toFixed(1)})
          </span>
        </div>

        <p className="text-sm text-gray-600 dark:text-gray-400 mt-2">Instructor Rating: {averageInstructorRating.toFixed(1)}</p>
        <p className="text-sm text-gray-600 dark:text-gray-400 mt-2">Type: {course.courseType}</p>
        <p className="text-sm text-gray-600 dark:text-gray-400 mt-2">Price: ${course.price}</p>
        <p className="text-sm text-gray-600 dark:text-gray-400">{course.time}</p>
      </div>
    </div>
  );
};

export default CourseCard;
