"use client";
import React, { useState } from 'react';
import Link from 'next/link';

const NavbarDropdown = ({ title, links }) => {
  const [isOpen, setIsOpen] = useState(false);
  const [timeoutId, setTimeoutId] = useState(null);

  const handleMouseEnter = () => {
    if (timeoutId) {
      clearTimeout(timeoutId);
      setTimeoutId(null);
    }
    setIsOpen(true);
  };

  const handleMouseLeave = () => {
    const id = setTimeout(() => {
      setIsOpen(false);
    }, 300); 
    setTimeoutId(id);
  };

  return (
    <div
    className="relative"
    onMouseEnter={handleMouseEnter}
    onMouseLeave={handleMouseLeave}
  >
    <span className="cursor-pointer text-lg font-semibold">{title}</span>
    <div
      className={`absolute mt-2 w-48 bg-white dark:bg-gray-900 text-black dark:text-white rounded-md shadow-lg z-50 transition-opacity duration-300 ease-in-out ${
        isOpen ? 'opacity-100' : 'opacity-0'
      }`}
      style={{ display: isOpen ? 'block' : 'none', left: '50%', transform: 'translateX(-100%)' }} // Adjusted here
    >
      <ul className="py-2">
        {links.map((link, index) => (
          <li key={index}>
            <Link href={link.href} className="block px-4 py-2 hover:bg-gray-200 dark:hover:bg-gray-700">
              {link.label}
            </Link>
          </li>
        ))}
      </ul>
    </div>
  </div>
  
  );
};

export default NavbarDropdown;
