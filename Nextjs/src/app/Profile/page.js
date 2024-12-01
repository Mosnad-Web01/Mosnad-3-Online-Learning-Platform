"use client";

import { useState, useEffect } from "react";
import Image from "next/image";
import { useRouter } from "next/navigation";
import { FaPen } from "react-icons/fa";
import { FaChevronDown, FaChevronUp } from "react-icons/fa";
import { fetchStudentById } from "../../services/api";

export default function Profile() {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const router = useRouter();
  const [darkMode, setDarkMode] = useState(false);
  const [isPurple, setIsPurple] = useState(true);
  const [openSection, setOpenSection] = useState(null);

  // Load theme and color preferences from localStorage
  useEffect(() => {
    const storedDarkMode = JSON.parse(localStorage.getItem("darkMode"));
    const storedIsPurple = JSON.parse(localStorage.getItem("isPurple"));

    if (storedDarkMode) {
      setDarkMode(storedDarkMode);
      document.documentElement.classList.add("dark");
    } else {
      document.documentElement.classList.remove("dark");
    }

    setIsPurple(storedIsPurple ?? true);

    document.documentElement.classList.toggle(
      "bg-purple-700",
      storedIsPurple && !storedDarkMode
    );
    document.documentElement.classList.toggle(
      "bg-sky-800",
      !storedIsPurple && !storedDarkMode
    );
  }, []);

  useEffect(() => {
    if (darkMode) {
      document.documentElement.classList.add("dark");
    } else {
      document.documentElement.classList.remove("dark");
    }

    document.documentElement.classList.toggle(
      "bg-purple-700",
      isPurple && !darkMode
    );
    document.documentElement.classList.toggle(
      "bg-sky-800",
      !isPurple && !darkMode
    );

    localStorage.setItem("darkMode", JSON.stringify(darkMode));
    localStorage.setItem("isPurple", JSON.stringify(isPurple));
  }, [darkMode, isPurple]);

  // Fetch user data from the API
  useEffect(() => {
    const fetchUser = async () => {
      try {
        const studentId = localStorage.getItem("studentId");
        if (!studentId) {
          router.push("/Login");
          return;
        }
        const response = await fetchStudentById(studentId); // استدعاء API لجلب بيانات المستخدم
        setUser(response.data); // ضبط بيانات المستخدم
        setError(null);
      } catch (err) {
        setError("Failed to load user data.");
      } finally {
        setLoading(false); // إيقاف عرض التحميل
      }
    };

    fetchUser();
  }, [router]);

  if (loading) {
    return (
      <div className="flex items-center justify-center h-screen">
        Loading...
      </div>
    );
  }

  if (error) {
    return (
      <div className="flex items-center justify-center h-screen">
        <p className="text-red-500">{error}</p>
      </div>
    );
  }

  const toggleSection = (section) => {
    setOpenSection(openSection === section ? null : section);
  };

  const handleEdit = () => {
    router.push("/edit-profile");
  };

  return (
    <div className="flex items-center justify-center min-h-screen w-full bg-white dark:bg-gray-800">
      <div className="flex flex-col gap-6 w-full max-w-3xl p-8 bg-gray-100 dark:bg-gray-900 rounded-lg shadow-xl">
        <h2 className="text-3xl font-bold text-center dark:text-white mb-6">
          Profile
        </h2>
        <div className="flex items-center justify-center gap-6 mb-8">
          <div className="relative">
            <Image
              src={user.profilePic || "/images/default.jpg"}
              alt="Profile Picture"
              className="rounded-full w-32 h-32 border-4 border-gray-600 dark:border-gray-800"
              width={128}
              height={128}
            />
          </div>
          <button className="bg-gray-600 dark:bg-gray-800 text-white text-xs py-2 px-6 rounded-lg transition-all duration-300 hover:bg-gray-400">
            Upload new photo
          </button>
        </div>
        <div className="text-sm text-gray-500 mt-2 text-center dark:text-gray-400">
          <p>Image should be PNG format with a size of up to 5MB.</p>
        </div>

        <hr className="my-6 border-gray-300 dark:border-gray-700" />

        <div
          className="flex items-center justify-between mb-4 cursor-pointer"
          onClick={() => toggleSection("personalInfo")}
        >
          <div className="text-lg font-semibold dark:text-white flex items-center">
            Personal Info
            {openSection === "personalInfo" ? (
              <FaChevronUp className="ml-2 h-5 w-5" />
            ) : (
              <FaChevronDown className="ml-2 h-5 w-5" />
            )}
          </div>
          <button
            className="flex items-center gap-2 text-black dark:text-white"
            onClick={(e) => {
              e.stopPropagation();
              handleEdit();
            }}
          >
            <FaPen className="h-5 w-5" />
            <span className="text-sm">Edit</span>
          </button>
        </div>

        {openSection === "personalInfo" && (
          <div className="flex flex-col gap-3 text-gray-600 dark:text-gray-300">
            <p>
              <strong>Name:</strong> {user.name}
            </p>
            <p>
              <strong>Email:</strong> {user.email}
            </p>
            <p>
              <strong>Phone:</strong> {user.phone || "N/A"}
            </p>
          </div>
        )}

        <hr className="my-6 border-gray-300 dark:border-gray-700" />

        {user.bio && (
          <div className="cursor-pointer" onClick={() => toggleSection("bio")}>
            <div className="flex items-center justify-between">
              <div className="text-lg font-semibold dark:text-white">Bio</div>
              {openSection === "bio" ? (
                <FaChevronUp className="h-5 w-5" />
              ) : (
                <FaChevronDown className="h-5 w-5" />
              )}
            </div>
            {openSection === "bio" && (
              <p className="mt-2 text-gray-600 dark:text-gray-400">
                {user.bio}
              </p>
            )}
          </div>
        )}
      </div>
    </div>
  );
}
