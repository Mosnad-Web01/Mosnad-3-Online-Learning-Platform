import React from 'react';
import { useRouter } from 'next/navigation';
import Image from 'next/image';

const CategoryCard = ({ category }) => {
  const router = useRouter();

  const handleCategoryClick = () => {
    router.push(`/courses/${category.id}`);
  };

  // Assuming your Laravel app serves images from the public directory
  const imageUrl = category.image ? `/storage/categories/${category.name}/${category.image}` : '/images/default-category.jpg';

  return (
    <div
      className="bg-gray-100 dark:bg-gray-900 text-black dark:text-white rounded-lg shadow-lg p-4 w-full sm:w-[320px] lg:w-[350px] mx-4 mb-6"
      onClick={handleCategoryClick}
    >
      <div className="w-full h-[200px]">
        <Image
          src={`http://localhost:8000${imageUrl}`} // ملاحظة تعديل عنوان الصورة ليشمل الدومين المحلي
          alt={category.name}
          width={500}
          height={192}
          className="w-full h-full object-cover rounded-lg"
          priority
        />
      </div>
      <h3 className="text-lg font-semibold text-gray-800 dark:text-white mt-4">
        {category.name}
      </h3>
    </div>
  );
};

export default CategoryCard;
