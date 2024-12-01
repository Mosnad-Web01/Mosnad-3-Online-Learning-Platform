"use client";
import { useState, useEffect } from "react";
import Link from "next/link";
import { FaSearch, FaMoon, FaSun, FaUser, FaBars, FaTimes } from "react-icons/fa";
import dynamic from "next/dynamic";
import NavbarDropdown from "../components/NavbarDropdown";
import Image from 'next/image';
import { logoutStudent, getCurrentStudent } from "../services/api";
import { toast } from "react-toastify";

// Delay loading of `react-scroll` to avoid conflicts with SSR
const ScrollLink = dynamic(() => import("react-scroll").then((mod) => mod.Link), { ssr: false });

const Navbar = () => {
  const [isDarkMode, setIsDarkMode] = useState(false);
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const [user, setUser] = useState(null);

  useEffect(() => {
    if (typeof window !== "undefined") {
      // استرجاع الثيم المحفوظ من localStorage
      const savedTheme = localStorage.getItem("theme");
      if (savedTheme) {
        setIsDarkMode(savedTheme === "dark");
      } else {
        setIsDarkMode(window.matchMedia("(prefers-color-scheme: dark)").matches);
      }
    }
  }, []);

  useEffect(() => {
    // جلب بيانات الطالب الحالي عند التحميل
    const fetchStudentData = async () => {
      try {
        const studentData = await getCurrentStudent();
        setUser(studentData);
      } catch (error) {
        console.error("Error fetching student data:", error);
        // يمكن إضافة معالجة إضافية إذا لزم الأمر
      }
    };

    fetchStudentData();
  }, []);

  useEffect(() => {
    if (typeof window !== "undefined") {
      if (isDarkMode) {
        document.documentElement.classList.add("dark");
        localStorage.setItem("theme", "dark");
      } else {
        document.documentElement.classList.remove("dark");
        localStorage.setItem("theme", "light");
      }
    }
  }, [isDarkMode]);

  const toggleTheme = () => {
    setIsDarkMode(!isDarkMode);
  };

  const toggleMenu = () => {
    setIsMenuOpen(!isMenuOpen);
  };

  const handleLogout = async () => {
    try {
      await logoutStudent();
      localStorage.removeItem("loggedInUser");
      setUser(null);
      toast.success("Logged out successfully");
    } catch (error) {
      toast.error("Failed to log out. Please try again.");
    }
  };

  return (
    <nav className="bg-gray-200 dark:bg-gray-900 text-gray-900 dark:text-white p-4 flex justify-between items-center flex-wrap z-50 relative">
      <div className="flex items-center space-x-4 w-full sm:w-auto justify-between sm:justify-start">
        <Link href="/" className="text-2xl font-bold">
          <Image
            src={isDarkMode ? "/images/dark_mood.svg" : "/images/light_mood.svg"}
            alt="Logo"
            width={50}
            height={50}
            className="h-8"
          />
        </Link>

        <div className="sm:hidden absolute right-4 flex items-center space-x-4">
          <button onClick={toggleTheme}>
            {isDarkMode ? (
              <FaSun className="text-white" />
            ) : (
              <FaMoon className="text-gray-700 dark:text-white" />
            )}
          </button>
          <Link href="/login">
            <FaUser className="text-gray-700 dark:text-white" />
          </Link>
        </div>
      </div>

      <button className="sm:hidden ml-4" onClick={toggleMenu}>
        <FaBars className="text-gray-700 dark:text-white" />
      </button>

      <div className={`sm:hidden fixed top-0 left-0 w-64 bg-gray-200 dark:bg-gray-900 text-gray-900 dark:text-white h-full transform ${isMenuOpen ? 'translate-x-0' : '-translate-x-full'} transition-transform`}>
        <div className="p-4">
          <button onClick={toggleMenu} className="text-white text-2xl absolute top-4 right-4">
            <FaTimes />
          </button>
          <ScrollLink to="about" smooth={true} duration={500} className="hover:text-gray-700 dark:hover:text-gray-300">
            About
          </ScrollLink>
          <ScrollLink to="services" smooth={true} duration={500} className="block py-2 hover:text-gray-700 dark:hover:text-gray-300">
            Services
          </ScrollLink>
          <ScrollLink to="contacts" smooth={true} duration={500} className="block py-2 hover:text-gray-700 dark:hover:text-gray-300">
            Contacts
          </ScrollLink>
          <Link href="/categories" className="block py-2 hover:text-gray-700 dark:hover:text-gray-300">Categories</Link>
        </div>
      </div>

      <div className="hidden sm:flex items-center space-x-6 sm:space-x-8 mt-4 sm:mt-0 sm:justify-between sm:w-auto">
        <ScrollLink to="about" smooth={true} duration={500} className="hover:text-gray-700 dark:hover:text-gray-300">
          About
        </ScrollLink>
        <ScrollLink to="services" smooth={true} duration={500} className="hover:text-gray-700 dark:hover:text-gray-300">
          Services
        </ScrollLink>
        <ScrollLink to="contacts" smooth={true} duration={500} className="hover:text-gray-700 dark:hover:text-gray-300">
          Contacts
        </ScrollLink>
        <Link href="/categories" className="hover:text-gray-700 dark:hover:text-gray-300">Categories</Link>
      </div>

      <div className="flex items-center mt-4 sm:mt-0 sm:w-96">
        <input
          type="text"
          placeholder="Search courses..."
          className="border-2 rounded-full px-4 py-2 w-40 sm:w-72 dark:bg-gray-700 dark:text-white"
        />
        <FaSearch className="ml-2 text-lg text-gray-500 dark:text-white" />
      </div>

      <div className="hidden sm:flex items-center space-x-4">
        <button onClick={toggleTheme}>
          {isDarkMode ? (
            <FaSun className="text-white" />
          ) : (
            <FaMoon className="text-gray-700 dark:text-white" />
          )}
        </button>
        {user ? (
          <NavbarDropdown
            title={<FaUser className="text-gray-700 dark:text-white" />}
            links={[
              { href: "/Profile", label: "Profile" },
              { href: "#", label: "Log out", onClick: handleLogout }, // تسجيل الخروج عند النقر
            ]}
          />
        ) : (
          <Link href="/Login">
            <FaUser className="text-gray-700 dark:text-white" />
          </Link>
        )}
      </div>
    </nav>
  );
};

export default Navbar;
