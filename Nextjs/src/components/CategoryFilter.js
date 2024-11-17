// src/components/CategoryFilter.js
import { useState } from 'react';
import mockData from '../data/mockData';

const CategoryFilter = () => {
  const [selectedCategory, setSelectedCategory] = useState('');

  const handleCategoryChange = (e) => {
    setSelectedCategory(e.target.value);
  };

  return (
    <div className="flex justify-center items-center space-x-4">
      <select
        value={selectedCategory}
        onChange={handleCategoryChange}
        className="border-2 rounded-full px-4 py-2"
      >
        <option value="">Select Category</option>
        {mockData.categories.map((category) => (
          <option key={category.id} value={category.name}>
            {category.name}
          </option>
        ))}
      </select>
    </div>
  );
};

export default CategoryFilter;
