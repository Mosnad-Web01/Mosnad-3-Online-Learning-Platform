"use client";
import React, { useState, useEffect } from 'react';
import { useRouter, useSearchParams } from 'next/navigation';
import { loginUser } from '@/utils/auth';

export default function Login() {
  const router = useRouter();
  const searchParams = useSearchParams();
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');

  useEffect(() => {
    // في حالة احتجت إلى عمليات تهيئة هنا
  }, []);

  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      const user = await loginUser(username, password);

      if (user) {
        // احصل على قيمة `redirect` من بارامترات البحث
        const redirectTo = searchParams.get('redirect') || '/';
        console.log('redirect to ' + redirectTo);
        router.push(redirectTo);  // توجيه المستخدم إلى الصفحة المحددة بعد تسجيل الدخول
      } else {
        setError('Invalid credentials. Please try again.');
      }
    } catch (error) {
      setError('An unexpected error occurred. Please try again.');
      console.error('Login error:', error);
    }
  };

  return (
    <div className="flex justify-center items-center h-screen bg-white dark:bg-gray-800">
      <form onSubmit={handleSubmit} className="bg-gray-100 dark:bg-gray-900 text-black dark:text-gray-200 p-6 rounded shadow-md max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg w-full">
        <h2 className="text-2xl font-bold mb-4">Login</h2>
        {error && <p className="text-red-500 mb-4">{error}</p>}
        <div className="mb-4">
          <label htmlFor="username" className="block text-gray-700">Username</label>
          <input
            type="text"
            id="username"
            className="w-full p-2 border border-gray-300 rounded mt-1"
            value={username}
            onChange={(e) => setUsername(e.target.value)}
            required
          />
        </div>
        <div className="mb-4">
          <label htmlFor="password" className="block text-gray-700">Password</label>
          <input
            type="password"
            id="password"
            className="w-full p-2 border border-gray-300 rounded mt-1"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            required
          />
        </div>
        <button type="submit" className="bg-gray-600 dark:bg-gray-800 text-white w-full p-2 rounded">Login</button>
      </form>
    </div>
  );
}
