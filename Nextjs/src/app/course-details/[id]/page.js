"use client";
import React, { useState, useEffect } from 'react';
import { useParams, useRouter } from 'next/navigation';
import { FaStar, FaArrowRight } from 'react-icons/fa';
import { fetchCourseById, fetchCourses, createEnrollment } from '@/services/api';
import ScrollableCourseList from '@/components/ScrollableCourseList';
import Link from 'next/link';
import Image from 'next/image'; 
import { motion } from 'framer-motion'; 

const CourseDetails = () => {
  const { id } = useParams();
  const router = useRouter();
  const [course, setCourse] = useState(null);
  const [instructor, setInstructor] = useState(null);
  const [relatedCourses, setRelatedCourses] = useState([]);
  const [averageCourseRating, setAverageCourseRating] = useState(0);
  const [isEnrolled, setIsEnrolled] = useState(false);  // حالة التسجيل
  const [isProcessing, setIsProcessing] = useState(false); // للتأكد من عدم تكرار النقرات

  useEffect(() => {
    const fetchCourseDetails = async () => {
      try {
        const response = await fetchCourseById(id);
    
        if (response && response.data) {
          const courseData = response.data;
    
          setCourse(courseData);
          setInstructor(courseData.instructor);
    
          const courseRatings = courseData.ratings || [];
          const avgRating =
            courseRatings.length === 0
              ? 0
              : courseRatings.reduce((total, rating) => total + rating.courseRating, 0) / courseRatings.length;
          setAverageCourseRating(avgRating);
    
          const relatedResponse = await fetchCourses();
          if (relatedResponse && relatedResponse.data) {
            const allCourses = relatedResponse.data;
            const related = allCourses.filter(c => c.category_id === courseData.category_id && c.id !== courseData.id);
            setRelatedCourses(related);
          }
    
          // تحقق من حالة التسجيل
          const enrollmentResponse = await checkEnrollment(courseData.id);
          if (enrollmentResponse && enrollmentResponse.data) {
            setIsEnrolled(enrollmentResponse.data.isEnrolled);
          }
        } else {
          console.error('Error: No data in the response');
        }
      } catch (error) {
        console.error("Error fetching course details:", error);
      }
    };
    

    fetchCourseDetails();
  }, [id]);

  const checkEnrollment = async (courseId) => {
    // استدعاء API للتحقق من التسجيل
    // return response
  };

  const handleEnrollment = async () => {
    if (isProcessing) return; // منع التكرار
    setIsProcessing(true);

    try {
      if (course.price === 0) {
        // إذا كانت الدورة مجانية، يتم تسجيل الطالب تلقائيًا
        await createEnrollment({ courseId: course.id });
        setIsEnrolled(true);
      } else {
        if (!isEnrolled) {
          // إذا كانت الدورة مدفوعة وغير مسجل، نقله إلى صفحة الدفع
          router.push(`/payment/${course.id}`);
        }
      }
    } catch (error) {
      console.error("Error during enrollment:", error);
    } finally {
      setIsProcessing(false);
    }
  };

  if (!course || !instructor) return <p>Course or instructor not found</p>;

  const ratingStars = Array.from({ length: 5 }, (_, index) => (
    <FaStar key={index} className={`${index < averageCourseRating ? 'text-yellow-500' : 'text-gray-400'}`} />
  ));

  return (
    <motion.div
      className="bg-white dark:bg-gray-800 text-black dark:text-white min-h-screen py-8 px-4"
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      transition={{ duration: 1 }} 
    >
      <div className="w-full px-0 py-0">
        {/* Course Details Section with Animation */}
        <motion.section
          className="bg-gray-100 dark:bg-gray-900 p-8 mt-0 rounded-lg shadow-lg"
          initial={{ opacity: 0, x: -100 }}
          animate={{ opacity: 1, x: 0 }}
          transition={{ duration: 0.7 }}
        >
          <div className="flex flex-col lg:flex-row">
            <div className="w-full lg:w-1/4 mb-8 lg:mb-0">
              <Image
                src={`/images/courses/${course.id}.jpg`}
                alt={course.course_name}
                width={300}
                height={450}
                className="rounded-lg shadow-lg"
                priority
              />
            </div>
            <div className="w-full lg:w-3/4 lg:ml-8">
              <h1 className="text-3xl md:text-4xl font-bold mb-2">{course.course_name}</h1>
              <p className="text-md md:text-lg mb-4">Instructor: {instructor.name}</p>
              <p className="text-md md:text-lg mb-4">Start Date: {course.start_date}</p>
              <p className="text-md md:text-lg mb-4">End Date: {course.end_date}</p>
              <p className="text-md md:text-lg mb-4">Language: {course.language}</p>
              <p className="text-md md:text-lg mb-4">Price: ${course.price}</p>
              <div className="flex items-center mt-4">
                {ratingStars}
                <span className="ml-2 text-sm">
                  ({averageCourseRating ? averageCourseRating.toFixed(1) : '0.0'})
                </span>
              </div>
              {/* زر الالتحاق بالدورة */}
              <button
                onClick={handleEnrollment}
                className="mt-4 py-2 px-6 bg-blue-500 text-white rounded-lg hover:bg-blue-600"
              >
                {course.price === 0 || isEnrolled ? 'Go to Lessons' : 'Enroll Now'}
              </button>
            </div>
          </div>
        </motion.section>


        <hr className="my-8 border-t border-gray-300 dark:border-gray-700" />

        {/* Requirements Section with Animation */}
        <motion.section
          className="my-6 p-4 bg-white dark:bg-gray-800 text-black dark:text-white"
          initial={{ opacity: 0, y: 50 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.7 }}
        >
          <h2 className="text-2xl font-semibold">Requirements</h2>
          <ul className="list-disc ml-6">
            {typeof course.requirements === 'string' && course.requirements.length > 0 ? (
              <li className="text-sm mt-2">{course.requirements}</li>
            ) : (
              <li className="text-sm mt-2">No data available</li>
            )}
          </ul>
        </motion.section>

        <hr className="my-8 border-t border-gray-300 dark:border-gray-700" />

        {/* Learning Outcomes Section with Animation */}
        <motion.section
          className="my-6 p-4 bg-white dark:bg-gray-800 text-black dark:text-white"
          initial={{ opacity: 0, x: 100 }}
          animate={{ opacity: 1, x: 0 }}
          transition={{ duration: 0.7 }}
        >
          <h2 className="text-2xl font-semibold">Learning Outcomes</h2>
          <ul className="list-disc ml-6">
            {typeof course.learning_outcomes === 'string' && course.learning_outcomes.length > 0 ? (
              <li className="text-sm mt-2">{course.learning_outcomes}</li>
            ) : (
              <li className="text-sm mt-2">No data available</li>
            )}
          </ul>
        </motion.section>

        <hr className="my-8 border-t border-gray-300 dark:border-gray-700" />

        {/* Course Content Section with Animation */}
        <motion.section
          className="my-6 p-4 bg-white dark:bg-gray-800 text-black dark:text-white"
          initial={{ opacity: 0, y: -50 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.7 }}
        >
          <h2 className="text-2xl font-semibold">Course Content</h2>
          <p className="text-sm mt-2">{course.description}</p>
        </motion.section>

        <hr className="my-8 border-t border-gray-300 dark:border-gray-700" />

        {/* Lessons Section with Go to button and Animation */}
        {course.lessons && course.lessons.length > 0 ? (
          <motion.section
            className="my-6 p-4 bg-white dark:bg-gray-800 text-black dark:text-white"
            initial={{ opacity: 0, scale: 0.9 }}
            animate={{ opacity: 1, scale: 1 }}
            transition={{ duration: 0.7 }}
          >
            <h2 className="text-2xl font-semibold">Lessons</h2>
            <div className="mt-4">
              <Link href={`/course-details/${course.id}/lessons`} passHref>
                <button className="flex items-center text-blue-500 hover:text-blue-700">
                  <span>Go to Lessons</span>
                  <FaArrowRight className="ml-2" />
                </button>
              </Link>
            </div>
          </motion.section>
        ) : (
          <motion.section
            className="my-6 p-4 bg-white dark:bg-gray-800 text-black dark:text-white"
            initial={{ opacity: 0, scale: 0.9 }}
            animate={{ opacity: 1, scale: 1 }}
            transition={{ duration: 0.7 }}
          >
            <h2 className="text-2xl font-semibold">Lessons</h2>
            <p>No lessons available for this course.</p>
          </motion.section>
        )}

        <hr className="my-8 border-t border-gray-300 dark:border-gray-700" />

        {/* Related Courses Section with Animation */}
        <motion.section
          className="my-6 p-4 bg-white dark:bg-gray-800 text-black dark:text-white"
          initial={{ opacity: 0, x: -100 }}
          animate={{ opacity: 1, x: 0 }}
          transition={{ duration: 0.7 }}
        >
          <h2 className="text-2xl font-semibold">Related Courses</h2>
          {relatedCourses.length > 0 ? (
            <ScrollableCourseList courses={relatedCourses} />
          ) : (
            <p>No related courses available</p>
          )}
        </motion.section>
      </div>
    </motion.div>
  );
};

export default CourseDetails;
