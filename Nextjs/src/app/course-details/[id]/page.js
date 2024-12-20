"use client";

import React, { useState, useEffect } from 'react';
import { useParams, useRouter } from 'next/navigation';
import { FaStar, FaArrowRight } from 'react-icons/fa';
import { fetchCourseById, fetchCourses, createEnrollment } from '@/services/api';
import ScrollableCourseList from '@/components/ScrollableCourseList';
import Link from 'next/link';
import Image from 'next/image';
import { motion } from 'framer-motion';
import Cookies from 'js-cookie';
import { ImPrevious } from 'react-icons/im';

const CourseDetails = () => {
  const { id } = useParams();
  const router = useRouter();
  const [course, setCourse] = useState(null);
  const [instructor, setInstructor] = useState(null);
  const [relatedCourses, setRelatedCourses] = useState([]);
  const [averageCourseRating, setAverageCourseRating] = useState(0);
  const [isEnrolled, setIsEnrolled] = useState(false);
  const [isProcessing, setIsProcessing] = useState(false);
  const [errorMessage, setErrorMessage] = useState(null);
  const [user, setUser] = useState(null);

  // Fetch course details
  useEffect(() => {
    const fetchCourseDetails = async () => {
      try {
        const response = await fetchCourseById(id);
        if (response?.data) {
          const courseData = response.data;

          setCourse(courseData);
          setInstructor(courseData.instructor);

          const ratings = courseData.ratings || [];
          const avgRating =
            ratings.length > 0
              ? ratings.reduce((total, r) => total + r.courseRating, 0) / ratings.length
              : 0;
          setAverageCourseRating(avgRating);

          const relatedResponse = await fetchCourses();
          const allCourses = relatedResponse?.data || [];
          const related = allCourses.filter(
            (c) => c.category_id === courseData.category_id && c.id !== courseData.id
          );
          setRelatedCourses(related);

          // Check enrollment status
          const enrollmentResponse = await api.get('/payments', { params: { courseId: courseData.id } });
          setIsEnrolled(enrollmentResponse?.data?.isEnrolled || false);
        } else {
          console.error('Error: Course data is missing.');
        }
      } catch (error) {
        console.error('Error fetching course details:', error);
      }
    };

    fetchCourseDetails();
  }, [id]);

  // Retrieve user data from cookies
  useEffect(() => {
    const userCookie = Cookies.get('user');
    if (userCookie) {
      try {
        setUser(JSON.parse(userCookie));
      } catch (error) {
        console.error('Error parsing user cookie:', error);
      }
    }
  }, []);

  const handleEnrollment = async () => {
    if (isProcessing || isEnrolled) return;
    setIsProcessing(true);
    setErrorMessage(null);

    try {
      if (course.price === 0) {
        const response = await createEnrollment({ courseId: course.id });
        if (response.status === 200) {
          setIsEnrolled(true);
        } else {
          throw new Error('Failed to enroll in the course.');
        }
      } else {
        router.push(`/payment/${course.id}`);
      }
    } catch (error) {
      setErrorMessage(error.response?.data?.message || 'An error occurred during enrollment.');
      console.error('Error during enrollment:', error);
    } finally {
      setIsProcessing(false);
    }
  };

  if (!course || !instructor) return <p>Course or instructor not found.</p>;

  const ratingStars = Array.from({ length: 5 }, (_, index) => (
    <FaStar key={index} className={index < averageCourseRating ? 'text-yellow-500' : 'text-gray-400'} />
  ));

  return (
    <motion.div
      className="bg-white dark:bg-gray-800 text-black dark:text-white min-h-screen py-8 px-4"
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      transition={{ duration: 1 }}
    >
      <div className="w-full px-0 py-0">
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
              <p className="text-md md:text-lg mb-4">Language: {course.language}</p>
              <p className="text-md md:text-lg mb-4">Price: ${course.price}</p>
              <div className="flex items-center mt-4">
                {ratingStars}
                <span className="ml-2 text-sm">
                  ({averageCourseRating ? averageCourseRating.toFixed(1) : '0.0'})
                </span>
              </div>

              <button
                onClick={handleEnrollment}
                disabled={isProcessing}
                className={`mt-4 py-2 px-6 rounded-lg ${
                  isEnrolled
                    ? 'bg-green-500 text-white'
                    : 'bg-blue-500 text-white hover:bg-blue-600'
                }`}
              >
                {isProcessing
                  ? 'Processing...'
                  : isEnrolled
                  ? 'Go to Lessons'
                  : 'Enroll Now'}
              </button>

              {errorMessage && <p className="text-red-500 mt-2">{errorMessage}</p>}
            </div>
          </div>
        </motion.section>

        <motion.section className="mt-6">
          <h2 className="text-2xl font-semibold">Related Courses</h2>
          {relatedCourses.length > 0 ? (
            <ScrollableCourseList courses={relatedCourses} />
          ) : (
            <p>No related courses available.</p>
          )}
        </motion.section>
      </div>
    </motion.div>
  );
};

export default CourseDetails;
