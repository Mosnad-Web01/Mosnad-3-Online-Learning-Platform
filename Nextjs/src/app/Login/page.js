"use client";
import React, { useState } from "react";
import { useRouter } from "next/navigation"; // للتنقل بين الصفحات
import { loginUser } from "@/services/api";
import { useUser } from "@/context/UserContext";

import Cookies from "js-cookie"; 
export default function Login() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
  const router = useRouter();
  const { setUser } = useUser(); // تحديث حالة المستخدم من السياق


  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const response = await loginUser({ email, password }); // استدعاء API لتسجيل الدخول
       // حفظ المستخدم في الكوكي
       Cookies.set("user", JSON.stringify(response.data.user), {
        expires: 7, // مدة الحفظ (7 أيام)
        path: "/", // متاح لكل المسارات
        // secure: true, // استخدم هذا في حالة HTTPS
        // sameSite: "", // لتجنب مشاكل CSRF
      });
            setUser(response.data.user); // تحديث حالة المستخدم في السياق

      setError(""); // إزالة رسالة الخطأ
      router.push("/"); // التوجيه إلى الصفحة الرئيسية
    } catch (error) {
      setError(
        error.response?.data?.error || "Invalid credentials. Please try again."
      );
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
        >
          Login
        </button>
        <p className="mt-4 text-sm text-center">
          Don’t have an account?{" "}
          <a href="/Register" className="text-blue-500 hover:underline">
            Create an account
          </a>
        </p>
      </form>
    </div>
  );
}
