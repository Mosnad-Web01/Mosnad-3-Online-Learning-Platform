import React, { useState, useEffect } from 'react';
import { motion } from 'framer-motion'; // استيراد framer-motion
import { FiChevronLeft, FiChevronRight } from 'react-icons/fi'; // استيراد أيقونات السهم
import CourseCard from './CourseCard'; // تأكد من أن المسار صحيح

const ScrollableCourseList = ({ courses = [] }) => { // Default value for courses
  const [currentIndex, setCurrentIndex] = useState(0);
  const [cardsToShow, setCardsToShow] = useState(3); // افتراض عدد البطاقات التي تظهر في البداية

  // تحديث عدد البطاقات التي تظهر بناءً على حجم الشاشة
  const updateCardsToShow = () => {
    const width = window.innerWidth;
    if (width >= 1024) { // الشاشات الكبيرة
      setCardsToShow(3);
    } else if (width >= 768) { // الشاشات المتوسطة
      setCardsToShow(2);
    } else { // الشاشات الصغيرة
      setCardsToShow(1);
    }
  };

  useEffect(() => {
    // تحديث عدد البطاقات عند تحميل الصفحة
    updateCardsToShow();

    // تحديث عدد البطاقات عند تغيير حجم الشاشة
    window.addEventListener('resize', updateCardsToShow);

    // تنظيف الحدث عند إلغاء تحميل المكون
    return () => {
      window.removeEventListener('resize', updateCardsToShow);
    };
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

  // Ensure courses is an array and slice is only called when courses are valid
  const displayedCourses = Array.isArray(courses) ? courses.slice(currentIndex, currentIndex + cardsToShow) : [];

  return (
    <div className="relative">
      <div className="flex items-center justify-between">
        {/* زر التمرير السابق مع تأثير انيميشن */}
        <motion.button 
          onClick={handlePrev} 
          className="bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 p-3 rounded-full hover:bg-gray-400 dark:hover:bg-gray-600 transition-all duration-300 transform hover:scale-105"
          whileHover={{ scale: 1.1 }} // تكبير الزر عند التمرير فوقه
          whileTap={{ scale: 0.9 }} // تصغير الزر عند النقر عليه
        >
          <FiChevronLeft size={24} />
        </motion.button>

        {/* الكورسات مع حركة الانزلاق */}
        <motion.div 
          className="flex flex-nowrap space-x-4 overflow-x-auto"
          initial={{ x: -100 }} // بداية من خارج الشاشة
          animate={{ x: 0 }} // الانزلاق إلى مكانه الطبيعي
          transition={{ type: "spring", stiffness: 100 }} // تحديد سرعة الحركة
        >
          {displayedCourses.map((course, index) => (
            <CourseCard key={course.id || index} course={course} /> // إضافة key فريد
          ))}
        </motion.div>

        {/* زر التمرير التالي مع تأثير انيميشن */}
        <motion.button 
          onClick={handleNext} 
          className="bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 p-3 rounded-full hover:bg-gray-400 dark:hover:bg-gray-600 transition-all duration-300 transform hover:scale-105"
          whileHover={{ scale: 1.1 }} // تكبير الزر عند التمرير فوقه
          whileTap={{ scale: 0.9 }} // تصغير الزر عند النقر عليه
        >
          <FiChevronRight size={24} />
        </motion.button>
      </div>
    </div>
  );
};

export default ScrollableCourseList;
