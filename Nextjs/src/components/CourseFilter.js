import React from 'react';

const CourseFilter = ({ 
  categories = [], 
  users = [], 
  difficultyLevels = [], 
  onFilterSelect 
}) => {
  // تصفية المدربين
  const instructors = users.filter(user => user.role === 'instructor');
  
  return (
    <div className="flex flex-wrap justify-center space-x-4 mt-4">
      {/* زر إظهار الكل */}
      <button
        className="bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 rounded-full px-6 py-2 mb-2 transition-all duration-300 transform hover:scale-105 hover:shadow-md"
        onClick={() => onFilterSelect(null)}  
      >
        Show All
      </button>

      {/* فلتر الفئات (قائمة منسدلة) */}
      <select
        className="bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 rounded-full px-6 py-2 mb-2 transition-all duration-300 transform hover:scale-105 hover:shadow-md"
        onChange={(e) => onFilterSelect({ type: 'category', value: e.target.value })}
      >
        <option value="">Category</option>
        {categories.map((category) => (
          <option key={category.id} value={category.id}>
            {category.name}
          </option>
        ))}
      </select>

      {/* فلتر التقييم */}
      <select
        className="bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 rounded-full px-6 py-2 mb-2 transition-all duration-300 transform hover:scale-105 hover:shadow-md"
        onChange={(e) => onFilterSelect({ type: 'rating', value: e.target.value })}
      >
        <option value="">Rating</option>
        {[1, 2, 3, 4, 5].map(rating => (
          <option key={rating} value={rating}>{rating} Stars & up</option>
        ))}
      </select>

      {/* فلتر المدربين */}
      <select
        className="bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 rounded-full px-6 py-2 mb-2 transition-all duration-300 transform hover:scale-105 hover:shadow-md"
        onChange={(e) => onFilterSelect({ type: 'instructor', value: e.target.value })}
      >
        <option value="">Instructor</option>
        {instructors.map(instructor => (
          <option key={instructor.id} value={instructor.id}>
            {instructor.name}
          </option>
        ))}
      </select>

      {/* فلتر المستوى */}
      <select
        className="bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 rounded-full px-6 py-2 mb-2 transition-all duration-300 transform hover:scale-105 hover:shadow-md"
        onChange={(e) => onFilterSelect({ type: 'level', value: e.target.value })}
      >
        <option value="">Level</option>
        {difficultyLevels.map(level => (
          <option key={level.id} value={level.id}>
            {level.level}
          </option>
        ))}
      </select>
    </div>
  );
};

export default CourseFilter;
