import React, { useState, useEffect } from 'react';
import { fetchCourses, fetchCategories } from '../services/api';
import ScrollableCourseList from './ScrollableCourseList';
import CourseFilter from './CourseFilter';

const CourseSection = () => {
  const [courses, setCourses] = useState([]);
  const [categories, setCategories] = useState([]);
  const [filter, setFilter] = useState({ type: null, value: null });

  useEffect(() => {
    const loadCourses = async () => {
      try {
        const response = await fetchCourses();
        setCourses(response.data);
      } catch (error) {
        console.error('Failed to fetch courses:', error);
      }
    };

    const loadCategories = async () => {
      try {
        const response = await fetchCategories();
        setCategories(response.data);
      } catch (error) {
        console.error('Failed to fetch categories:', error);
      }
    };

    loadCourses();
    loadCategories();
  }, []);

  const handleFilterSelect = (filterOption) => setFilter(filterOption);

  const filteredCourses = courses.filter((course) => {
    if (!filter?.type || !filter.value) return true;
    if (filter.type === 'category') return course.category_id === filter.value;
    return true;
  });

  return (
    <section className="py-16 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-800 text-black dark:text-white">
      <h2 className="text-3xl font-bold text-center mb-6">
        Discover a World of Knowledge – Empowering You to Learn and Grow with Our Expert-Led Courses
      </h2>
      <h3 className="text-xl text-center text-gray-600 dark:text-gray-300 mb-6">
        Browse Our Courses
      </h3>
      {categories.length === 0 && courses.length === 0 ? (
        <div className="text-center text-gray-700 dark:text-gray-300">
          No Courses or Categories Available
        </div>
      ) : (
        <>
          <CourseFilter categories={categories} onFilterSelect={handleFilterSelect} />
          <ScrollableCourseList courses={filteredCourses} />
        </>
      )}
    </section>
  );
};

export default CourseSection;
