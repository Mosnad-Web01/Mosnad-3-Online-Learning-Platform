// src/components/CategoryCard.js
import React from 'react';
import { useRouter } from 'next/navigation';
import Image from 'next/image';

const CategoryCard = ({ category }) => {
  const router = useRouter();


  const handleCategoryClick = () => {
    router.push(`/courses/${category.id}`);
  };

  return (
    <div
      className="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-4"
      onClick={handleCategoryClick}
    >
      <div className="bg-white dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden cursor-pointer transform hover:scale-105 transition-all">
      <Image
        src={category.image || '/images/default-category.jpg'} 
        alt={category.name}
        width={500}  
        height={192} 
        className="w-full h-48 object-cover"
      />
        <div className="p-4">
          <h3 className="text-xl font-semibold text-gray-800 dark:text-white">
            {category.name}
          </h3>
        </div>
      </div>
    </div>
  );
};

export default CategoryCard;
