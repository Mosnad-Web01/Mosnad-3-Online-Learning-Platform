import React from 'react';
import { FaArrowRight } from 'react-icons/fa';
import Link from 'next/link';
import mockData from '../data/mockData';

const CourseCard = ({ title, description, instructor, color, id, categoryId, levelId, language, time, user }) => {
  const category = mockData.categories.find(cat => cat.id === categoryId)?.name || 'Uncategorized';
  const level = mockData.difficultyLevels.find(lvl => lvl.id === levelId)?.level || 'Unknown';

  return (
    <div
      className={`p-6 rounded-2xl shadow-lg ${color} transform transition-all duration-300 hover:scale-105 hover:shadow-xl cursor-pointer flex-1 sm:max-w-full md:max-w-[48%] lg:max-w-[30%] xl:max-w-[23%] w-full`}
    >
      <h2 className={`text-2xl font-bold text-${color}-800 mb-2 truncate`}>{title}</h2>
      <p className="text-base text-gray-700 mb-3 truncate">{description}</p>
      <p className="text-sm text-gray-500 mb-1">Created by {instructor}</p>
      <p className="text-sm text-gray-500 mb-1">Category: {category}</p>
      <p className="text-sm text-gray-500 mb-1">Level: {level}</p>
      <p className="text-sm text-gray-500 mb-1">Language: {language || 'Not specified'}</p>
      <p className="text-sm text-gray-500 mb-4">Time: {time || 'Not specified'}</p>
      {user && <p className="text-sm text-gray-500 mb-2">Associated User: {user.name}</p>}

      <div className="flex items-center justify-between">
        <span className={`text-sm text-${color}-500`}>
          <Link href={`/course-details/${id}`}>View Details</Link>
        </span>
        <FaArrowRight className={`text-${color}-500`} />
      </div>
    </div>
  );
};

export default CourseCard;
