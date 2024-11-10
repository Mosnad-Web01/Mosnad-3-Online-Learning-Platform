'use client';

import React, { useState, useEffect } from 'react';
import { useRouter } from 'next/navigation';
import CourseCard from '../../components/CourseCard';
import UserPanel from '../../components/UserPanel';
import mockData from '../../data/mockData';
import Calendar from 'react-calendar';
import 'react-calendar/dist/Calendar.css';
import LoginRedirect from '../../components/LoginRedirect';

export default function Dashboard() {
  const [isLoggedIn, setIsLoggedIn] = useState(false);
  const [loggedInUser, setLoggedInUser] = useState(null);
  const onlineUsers = mockData.onlineUsers;
  const router = useRouter();

  useEffect(() => {
    const storedUser = JSON.parse(localStorage.getItem('loggedInUser')); // استرجاع بيانات المستخدم من localStorage
    if (storedUser && storedUser.isLoggedIn) {
      setIsLoggedIn(true);
      setLoggedInUser(storedUser);
    }
  }, []);

  return (
    <div className="flex flex-wrap p-5 space-x-6 bg-white dark:bg-gray-800">
      {/* قسم الدورات - My Courses */}
      <div className="flex-1 w-full lg:w-3/4">
        <h2 className="text-3xl font-bold mb-4">My Courses</h2>
        <div className="overflow-hidden">
          {isLoggedIn ? (
            <div className="flex flex-wrap gap-6">
              {mockData.courses
                .filter((course) => course.instructorId === loggedInUser.id)
                .map((course) => (
                  <CourseCard
                    key={course.id}
                    title={course.title}
                    description={course.description}
                    instructor={course.instructor}
                    color={course.color}
                  />
                ))}
            </div>
          ) : (
            <div>
              <LoginRedirect />
              <p className="mt-2 text-gray-600">Please log in to view your courses</p>
            </div>
          )}
        </div>
      </div>

      {/* قسم التقويم وUserPanel */}
      <div className="w-full lg:w-1/4 mt-6 lg:mt-0">
        <h2 className="text-3xl font-bold mb-4">Calendar</h2>
        <div className="bg-white shadow-lg p-4 rounded-lg mb-6">
          <Calendar className="custom-calendar" />
        </div>

        <div className="overflow-y-auto" style={{ maxHeight: 'calc(100vh - 200px)' }}>
          <UserPanel user={isLoggedIn ? loggedInUser : null} onlineUsers={onlineUsers} />
        </div>
      </div>
    </div>
  );
}
