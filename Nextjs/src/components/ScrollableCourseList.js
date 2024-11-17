import React from 'react';
import { motion } from 'framer-motion';
import { FiChevronLeft, FiChevronRight } from 'react-icons/fi';
import CourseCard from './CourseCard';

const ScrollableCourseList = ({ courses = [] }) => {
  const [currentIndex, setCurrentIndex] = React.useState(0);
  const [cardsToShow, setCardsToShow] = React.useState(3);

  const updateCardsToShow = () => {
    const width = window.innerWidth;
    if (width >= 1024) {
      setCardsToShow(3);
    } else if (width >= 768) {
      setCardsToShow(2);
    } else {
      setCardsToShow(1);
    }
  };

  React.useEffect(() => {
    updateCardsToShow();
    window.addEventListener('resize', updateCardsToShow);
    return () => window.removeEventListener('resize', updateCardsToShow);
  }, []);

  const handleNext = () => {
    if (currentIndex < courses.length - cardsToShow) {
      setCurrentIndex(currentIndex + 1);
    }
  };

  const handlePrev = () => {
    if (currentIndex > 0) {
      setCurrentIndex(currentIndex - 1);
    }
  };

  const displayedCourses = courses.slice(currentIndex, currentIndex + cardsToShow);

  if (courses.length === 0) {
    return (
      <div className="text-center py-10 text-gray-700 dark:text-gray-300">
        No Courses Available
      </div>
    );
  }

  return (
    <div className="relative">
      <div className="flex items-center justify-between">
        <motion.button
          onClick={handlePrev}
          className="bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 p-3 rounded-full hover:bg-gray-400 dark:hover:bg-gray-600 transition-all duration-300 transform hover:scale-105"
          whileHover={{ scale: 1.1 }}
          whileTap={{ scale: 0.9 }}
        >
          <FiChevronLeft size={24} />
        </motion.button>
        <motion.div
          className="flex flex-nowrap space-x-4 overflow-x-auto"
          initial={{ x: -100 }}
          animate={{ x: 0 }}
          transition={{ type: 'spring', stiffness: 100 }}
        >
          {displayedCourses.map((course, index) => (
            <CourseCard key={course.id || index} course={course} />
          ))}
        </motion.div>
        <motion.button
          onClick={handleNext}
          className="bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 p-3 rounded-full hover:bg-gray-400 dark:hover:bg-gray-600 transition-all duration-300 transform hover:scale-105"
          whileHover={{ scale: 1.1 }}
          whileTap={{ scale: 0.9 }}
        >
          <FiChevronRight size={24} />
        </motion.button>
      </div>
    </div>
  );
};

export default ScrollableCourseList;
