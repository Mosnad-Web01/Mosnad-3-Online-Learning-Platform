import React from 'react';

const CourseFilter = ({
  categories = [],
  users = [],
  difficultyLevels = [],
  onFilterSelect,
}) => {
  // تصفية المستخدمين الذين دورهم "instructor"
  const instructors = users.filter((user) => user.role === 'instructor');

  return (
    <div className="flex flex-wrap justify-center space-x-4 mt-4">
      {/* زر إظهار الكل */}
      <button
        className="bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200 rounded-full px-6 py-2 mb-2 transition-all duration-300 transform hover:scale-105 hover:shadow-md"
        onClick={() => onFilterSelect(null)}
      >
        Show All
      </button>

      {/* فلتر الفئات */}
      <select
        className="bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200 rounded-full px-6 py-2 mb-2 transition-all duration-300 transform hover:scale-105 hover:shadow-md"
        onChange={(e) => {
          const value = e.target.value ? parseInt(e.target.value, 10) : null;
          onFilterSelect({ type: 'category', value });
        }}
      >
        <option value="">Category</option>
        {categories.map((category) => (
          <option key={category.id} value={category.id}>
            {category.name}
          </option>
        ))}
      </select>

      
    </div>
  );
};

export default CourseFilter;
