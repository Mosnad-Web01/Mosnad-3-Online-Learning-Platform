'use client';
import React, { useState, useEffect } from 'react';
import { FaHome, FaBook, FaUserFriends, FaCog, FaMoon, FaSun, FaPalette, FaUser, FaBell } from 'react-icons/fa';
import Link from 'next/link';

const Sidebar = ({ selectedItem }) => {
  const [darkMode, setDarkMode] = useState(false);
  const [isPurple, setIsPurple] = useState(true);

  useEffect(() => {
    if (darkMode) {
      document.documentElement.classList.add('dark');
    } else {
      document.documentElement.classList.remove('dark');
    }
  
    // تعيين لون الخلفية بناءً على اختيار المستخدم
    document.documentElement.classList.toggle('bg-purple-700', isPurple && !darkMode);
    document.documentElement.classList.toggle('bg-sky-800', !isPurple && !darkMode);
  
    // حفظ الوضع الليلي ولون الخلفية في localStorage
    localStorage.setItem('darkMode', darkMode);
    localStorage.setItem('isPurple', isPurple);
  }, [darkMode, isPurple]);

  const toggleDarkMode = () => setDarkMode(!darkMode);

  const toggleColorScheme = () => setIsPurple(!isPurple);

  return (
    <div
      className={`w-1/5 h-screen p-5 text-white transition-colors duration-700 ease-in-out ${
        isPurple && !darkMode ? 'bg-purple-700' : 'bg-sky-800'
      } ${darkMode ? 'dark:bg-gray-800' : ''}`}
    >
      {/* محتوى القائمة الجانبية */}
      <h2 className="text-center text-xs sm:text-sm md:text-lg lg:text-xl font-semibold mb-6">Online Learning</h2>
      <ul className="space-y-4">
        {[
          { name: 'Dashboard', icon: <FaHome />, link: '/Dashboard' },
          { name: 'Courses', icon: <FaBook />, link: '/Courses' },
          { name: 'Catalog', icon: <FaBook />, link: '/Catalog' },
          { name: 'Friends', icon: <FaUserFriends />, link: '/Friends' },
          { name: 'Profile', icon: <FaUser />, link: '/Profile' },
          { name: 'Settings', icon: <FaCog />, link: '/Settings' },
          { name: 'Notifications', icon: <FaBell />, link: '/Notifications' },
        ].map((item) => (
          <li key={item.name} className={`flex items-center gap-3 p-2 rounded-md cursor-pointer transition-colors duration-300 ${selectedItem === item.name ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10'}`}>
            <Link href={item.link} className="flex items-center gap-3">
              <span className="text-lg">{item.icon}</span>
              <span className="capitalize hidden sm:inline">{item.name}</span>
            </Link>
          </li>
        ))}
      </ul>

      {/* Dark mode and color scheme buttons */}
      <div className="absolute bottom-4 left-4 flex flex-col sm:flex-col lg:flex-row gap-4 sm:gap-2">
        <button onClick={toggleDarkMode} className="p-2 transition-colors duration-300">
          {darkMode ? <FaSun /> : <FaMoon />}
        </button>
        <button onClick={toggleColorScheme} className="p-2 transition-colors duration-300">
          <FaPalette />
        </button>
      </div>
    </div>
  );
};

export default Sidebar;
