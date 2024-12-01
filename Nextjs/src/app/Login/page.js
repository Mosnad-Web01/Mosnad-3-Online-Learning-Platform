'use client';
import axios from 'axios';
import React, { useState } from 'react';
import { loginUser } from '@/services/api';
import { useRouter } from 'next/navigation';

const Login = () => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);

  const router = useRouter();

  // دالة مساعدة للحصول على التوكن إذا لم يكن موجودًا
  const getCsrfToken = async () => {
    await axios.get('http://localhost:8000/api/sanctum/csrf-cookie', {
      withCredentials: true,
    });
    return document.cookie
      .split('; ')
      .find(row => row.startsWith('XSRF-TOKEN='))
      ?.split('=')[1];
  };
  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');
    setLoading(true);

    try {
          let csrfToken = null;

      // التأكد من وجود التوكن أولاً
      csrfToken = document.cookie
        .split('; ')
        .find(row => row.startsWith('XSRF-TOKEN='))
        ?.split('=')[1];
  
      // إذا لم يكن التوكن موجودًا، نقوم بطلبه
      if (!csrfToken) {
        csrfToken = await getCsrfToken(); // استدعاء دالة الحصول على التوكن
      }

      // تحقق مرة أخرى من التوكن بعد المحاولة
      if (!csrfToken) {
        throw new Error('Failed to retrieve CSRF token');
      }
  
      // استدعاء API لتسجيل الدخول بعد التأكد من وجود التوكن
      const response = await loginUser({ email, password });
      console.log('Login successful:', response);
  
      // إذا تم تسجيل الدخول بنجاح، توجه المستخدم
      if (response) {
        router.push('/'); // توجيه إلى صفحة الهوم
      }
    } catch (err) {
      console.error('Login error:', err);
      const errorMessage =
        err.response?.data?.message || 'Invalid email or password.';
      setError(errorMessage);
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="flex justify-center items-center h-screen bg-white dark:bg-gray-800">
      <form
        onSubmit={handleSubmit}
        className="bg-gray-100 dark:bg-gray-900 text-black dark:text-gray-200 p-6 rounded shadow-md max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg w-full"
      >
        <h2 className="text-2xl font-bold mb-4">Login</h2>
        {error && <p className="text-red-500 mb-4">{error}</p>}
        <div className="mb-4">
          <label htmlFor="email" className="block text-gray-700">
            Email
          </label>
          <input
            type="email"
            id="email"
            className="w-full p-2 border border-gray-300 rounded mt-1"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            required
          />
        </div>
        <div className="mb-4">
          <label htmlFor="password" className="block text-gray-700">
            Password
          </label>
          <input
            type="password"
            id="password"
            className="w-full p-2 border border-gray-300 rounded mt-1"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            required
          />
        </div>
        <button
          type="submit"
          className="bg-gray-600 dark:bg-gray-800 text-white w-full p-2 rounded"
          disabled={loading}
        >
          {loading ? 'Logging in...' : 'Login'}
        </button>
      </form>
    </div>
  );
};

export default Login;
