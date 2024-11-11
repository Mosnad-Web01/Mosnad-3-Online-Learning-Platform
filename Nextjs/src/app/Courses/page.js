'use client';

import React, { useState, useEffect } from 'react';
import CourseCard from '../../components/CourseCard';
import FilterBar from '../../components/FilterBar';
import mockData from '../../data/mockData';
import PaginationButton from '../../components/PaginationButton';

export default function AllCourses({ isPurple }) {
  const [filters, setFilters] = useState({
    time: '',
    level: '',
    language: '',
    type: '',
  });

  const [currentPage, setCurrentPage] = useState(1);
  const [coursesPerPage, setCoursesPerPage] = useState(8); 
  const [windowWidth, setWindowWidth] = useState(0); 

  // تحديد عدد الدورات المعروضة بناءً على حجم الشاشة
  useEffect(() => {
    if (typeof window !== 'undefined') {
      const handleResize = () => setWindowWidth(window.innerWidth);

      window.addEventListener('resize', handleResize);

      // تحديث قيمة coursesPerPage بناءً على حجم الشاشة
      handleResize(); 

      return () => {
        window.removeEventListener('resize', handleResize);
      };
    }
  }, []); // تنفيذ التأثير فقط على العميل

  useEffect(() => {
    if (windowWidth < 640) {  // شاشات الهواتف الصغيرة جدًا
      setCoursesPerPage(3);
    } else {  // الشاشات الأكبر من ذلك
      setCoursesPerPage(8);
    }
  }, [windowWidth]); // إعادة التقييم عندما يتغير windowWidth

  // تصفية الدورات حسب الفلاتر
  const filteredCourses = mockData.courses.filter((course) => {
    return (
      (filters.time ? course.time === filters.time : true) &&
      (filters.level ? course.levelId === filters.level : true) &&
      (filters.language ? course.language === filters.language : true) &&
      (filters.type ? course.type === filters.type : true)
    );
  });

  // تحديد الدورات التي ستعرض في الصفحة الحالية
  const indexOfLastCourse = currentPage * coursesPerPage;
  const indexOfFirstCourse = indexOfLastCourse - coursesPerPage;
  const currentCourses = filteredCourses.slice(indexOfFirstCourse, indexOfLastCourse);

  // تغيير الفلاتر
  const handleFilterChange = (type, value) => {
    setFilters((prevFilters) => ({
      ...prevFilters,
      [type]: value,
    }));
  };

  // التعامل مع عرض المزيد والعودة
  const handleNextPage = () => {
    setCurrentPage((prevPage) => prevPage + 1);
  };

  const handlePreviousPage = () => {
    setCurrentPage((prevPage) => prevPage - 1);
  };

  // تحديد اللون بناءً على الوضع
  const colorScheme = isPurple ? 'bg-purple-700' : 'bg-sky-800';

  return (
    <div className="space-y-4">
      <FilterBar onFilterChange={handleFilterChange} />
      
      <div className="flex flex-wrap gap-4">
        {currentCourses.map((course) => (
          <CourseCard
            key={course.id}
            title={course.title}
            description={course.description}
            instructor={course.instructor}
            color={course.color}
            id={course.id}
            categoryId={course.categoryId}
            levelId={course.levelId}
            language={course.language}
            time={course.time}
          />
        ))}
      </div>
      
      <div className="flex justify-between mt-4">
        <PaginationButton 
          onClick={handlePreviousPage} 
          direction="left" 
          isDisabled={currentPage === 1} 
          color={colorScheme}  
        />
        <PaginationButton 
          onClick={handleNextPage} 
          direction="right" 
          isDisabled={indexOfLastCourse >= filteredCourses.length} 
          color={colorScheme}  
        />
      </div>
    </div>
  ); 
}
