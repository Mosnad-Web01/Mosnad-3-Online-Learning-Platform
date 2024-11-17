"use client";
import React, { useEffect, useState } from 'react';
import { useParams } from 'next/navigation';
import { fetchCourses } from '@/services/api'; 
import ScrollableCourseList from '@/components/ScrollableCourseList';

const CoursesByCategoryPage = () => {
  const { categoryId } = useParams(); 
  const [courses, setCourses] = useState([]);

  useEffect(() => {
    const fetchCategoryCourses = async () => {
      try {
        const response = await fetchCourses(); 
        const categoryCourses = response.data.filter(course => course.category_id === parseInt(categoryId));
        setCourses(categoryCourses);
      } catch (error) {
        console.error("Error fetching courses:", error);
      }
    };

    fetchCategoryCourses();
  }, [categoryId]);

  return (
    <div className="bg-white dark:bg-gray-800 text-black dark:text-white min-h-screen py-8 px-4">
      <h1 className="text-3xl font-bold mb-6 text-center">Courses in Category</h1>
      {courses.length > 0 ? (
        <ScrollableCourseList courses={courses} />
      ) : (
        <p>No courses available in this category</p>
      )}
    </div>
  );
};

export default CoursesByCategoryPage;
