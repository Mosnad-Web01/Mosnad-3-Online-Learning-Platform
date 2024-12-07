import React from 'react';
import Image from 'next/image';
import Link from 'next/link';

const CourseCard = ({ course }) => {
  return (
    <div className="bg-gray-100 dark:bg-gray-900 text-black dark:text-white rounded-lg shadow-lg p-4 w-full sm:w-[320px] lg:w-[350px] mx-4 mb-6">
      <Link href={`/course-details/${course.id}`}>
        <Image
          src={course.image_url || '/images/placeholder.jpg'}
          alt={course.course_name}
          width={500}
          height={300}
          className="w-full h-[200px] object-cover rounded-lg"
          priority
        />
      </Link>
      <h3 className="text-lg font-semibold">
        {course.course_name.length > 50
          ? `${course.course_name.substring(0, 50)}...`
          : course.course_name}
      </h3>
      <p className="text-sm">
        {course.description || 'No description available.'}
      </p>
      <p className="text-sm">
        Price: {course.is_free ? 'Free' : `$${course.price}`}
      </p>
    </div>
  );
};

export default CourseCard;
