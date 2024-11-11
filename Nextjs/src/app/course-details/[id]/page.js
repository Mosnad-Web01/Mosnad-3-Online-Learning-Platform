'use client';

import { useParams } from 'next/navigation';
import React, { useEffect, useState } from 'react';
import mockData from '../../../data/mockData';

const CourseDetails = () => {
  const { id } = useParams();
  const [course, setCourse] = useState(null);
  const [user, setUser] = useState(null);

  useEffect(() => {
    if (typeof window !== 'undefined' && id) {
      const foundCourse = mockData.courses.find(course => course.id === id);
      if (foundCourse) {
        setCourse(foundCourse);
        setUser(mockData.users.find(user => user.id === foundCourse.instructorId));
      }
    }
  }, [id]);

  if (!course) {
    return <div>Loading...</div>;
  }

  const category = mockData.categories.find(cat => cat.id === course.categoryId)?.name || 'Uncategorized';
  const level = mockData.difficultyLevels.find(lvl => lvl.id === course.levelId)?.level || 'Unknown';

  return (
    <div className="p-6 max-w-7xl mx-auto">
      <h1 className="text-3xl font-bold mb-4">{course.title}</h1>
      <p className="text-lg text-gray-700 my-4">{course.description}</p>

      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <p className="text-md text-gray-500">Instructor: {user?.name || 'Unknown'}</p>
          <p className="text-md text-gray-500">Category: {category}</p>
          <p className="text-md text-gray-500">Level: {level}</p>
          <p className="text-md text-gray-500">Language: {course.language}</p>
          <p className="text-md text-gray-500">Type: {course.type}</p>
          <p className="text-md text-gray-500">Time: {course.time}</p>
        </div>

        <div className={`p-3 mt-4 rounded ${course.color}`}>
          <p className="text-white">Course color</p>
        </div>
      </div>
    </div>
  );
};

export default CourseDetails;
