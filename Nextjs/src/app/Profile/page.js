// pages/profile.js
'use client';

import { useState, useEffect } from 'react';
import Image from 'next/image';
import { useRouter } from 'next/navigation';
import { FaPen } from 'react-icons/fa';
import {fetchUserprofile} from '@/services/api';
export default function Profile() {
  const [user, setUser] = useState(null);
  const [editableUser, setEditableUser] = useState(null);
  const router = useRouter();

  // Check authentication and fetch user data
  useEffect(() => {
    const fetchUserData = async () => {
      // if (!isAuthenticated()) {
      //   router.push('/login');
      //   return;
      // }

      try {
        const userData = await fetchUserprofile();

        if (userData && userData.user) {
          setUser(userData.user);
          setEditableUser({ ...userData.user }); // Clone the user data for editing
        } else {
          throw new Error('User profile not found');
        }
      } catch (error) {
        console.error('Error fetching user data:', error.message);
        router.push('/login'); // Redirect to login if there's an error
      }
    };

    fetchUserData();
  }, [router]);

  // Handle input changes for editable fields
  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setEditableUser((prev) => ({
      ...prev,
      [name]: value,
    }));
  };

  // Handle form submission to update user data
  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      const updatedUser = await fetchData('/update-profile', 'POST', editableUser, router);
      setUser(updatedUser.user); // Update the displayed user data
      setEditableUser({ ...updatedUser.user }); // Update the editable state
      alert('Profile updated successfully');
    } catch (error) {
      console.error('Error updating profile:', error.message);
      alert('Error updating profile');
    }
  };

  if (!user || !editableUser) {
    return <p>Loading...</p>;
  }

  return (
    <div className="flex items-center justify-center min-h-screen w-full bg-white dark:bg-gray-800">
      <div className="flex flex-col gap-6 w-full max-w-3xl p-8 bg-gray-100 dark:bg-gray-900 rounded-lg shadow-xl">
        <h2 className="text-3xl font-bold text-center dark:text-white mb-6">Profile</h2>

        {/* Profile Picture */}
        <div className="flex items-center justify-center gap-6 mb-8">
          <div className="relative">
            <Image
              src={user.profilePic || '/images/default.jpg'}
              alt="Profile Picture"
              className="rounded-full w-32 h-32 border-4 border-gray-600 dark:border-gray-800"
              width={128}
              height={128}
            />
          </div>
        </div>

        <form onSubmit={handleSubmit} className="space-y-6">
          {/* Name Field */}
          <div className="flex flex-col">
            <label htmlFor="name" className="text-lg text-gray-700 dark:text-gray-300">
              Name:
            </label>
            <input
              type="text"
              id="name"
              name="name"
              value={editableUser.name || ''}
              onChange={handleInputChange}
              className="mt-2 p-2 rounded-md border border-gray-300 dark:border-gray-700 dark:bg-gray-800"
              required
            />
          </div>

          {/* Email Field */}
          <div className="flex flex-col">
            <label htmlFor="email" className="text-lg text-gray-700 dark:text-gray-300">
              Email:
            </label>
            <input
              type="email"
              id="email"
              name="email"
              value={editableUser.email || ''}
              onChange={handleInputChange}
              className="mt-2 p-2 rounded-md border border-gray-300 dark:border-gray-700 dark:bg-gray-800"
              required
            />
          </div>

          {/* Phone Field */}
          <div className="flex flex-col">
            <label htmlFor="phone" className="text-lg text-gray-700 dark:text-gray-300">
              Phone:
            </label>
            <input
              type="text"
              id="phone"
              name="phone"
              value={editableUser.phone || ''}
              onChange={handleInputChange}
              className="mt-2 p-2 rounded-md border border-gray-300 dark:border-gray-700 dark:bg-gray-800"
            />
          </div>

          {/* Bio Field */}
          <div className="flex flex-col">
            <label htmlFor="bio" className="text-lg text-gray-700 dark:text-gray-300">
              Bio (optional):
            </label>
            <textarea
              id="bio"
              name="bio"
              value={editableUser.bio || ''}
              onChange={handleInputChange}
              className="mt-2 p-2 rounded-md border border-gray-300 dark:border-gray-700 dark:bg-gray-800"
            />
          </div>

          {/* Save Button */}
          <div className="flex justify-center">
            <button
              type="submit"
              className="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-500 transition-all duration-300"
            >
              Save Changes
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}
