import React, { useState } from 'react';
import mockData from '../data/mockData';
import ScrollableCourseList from './ScrollableCourseList';
import CourseFilter from './CourseFilter';

const CourseSection = () => {
  const [filter, setFilter] = useState({ type: null, value: null });

  const handleFilterSelect = (filterOption) => {
    setFilter(filterOption);
  };

  const filteredCourses = mockData.courses.filter(course => {
    if (!filter?.type || !filter.value) return true;
  
    switch (filter.type) {
      case 'category':
        return course.categoryId === filter.value;
      case 'instructor':
        return course.instructorId === filter.value;
      case 'level':
        return course.levelId === filter.value;
      case 'rating':
        const courseRating = mockData.ratings
          .filter(rating => rating.courseId === course.id)
          .reduce((acc, r) => acc + r.courseRating, 0) / (mockData.ratings.filter(rating => rating.courseId === course.id).length || 1);
        return courseRating >= filter.value;
      default:
        return true;
    }
  });

  return (
    <section className="py-16 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-800 text-black dark:text-white">
      {/* Main Title */}
      <h2 className="text-3xl font-bold text-center mb-6">
        Discover a World of Knowledge – Empowering You to Learn and Grow with Our Expert-Led Courses
      </h2>

      {/* Sub-title */}
      <h3 className="text-xl text-center text-gray-600 dark:text-gray-300 mb-6">
        Browse Our Courses
      </h3>

      <CourseFilter 
        categories={mockData.categories}
        users={mockData.users}  // Changing instructors to users
        difficultyLevels={mockData.difficultyLevels}  // Changing levels to difficultyLevels
        onFilterSelect={handleFilterSelect}
      />

      <ScrollableCourseList courses={filteredCourses} />
    </section>
  );
};

export default CourseSection;
