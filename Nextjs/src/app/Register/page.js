"use client";
import React, { useState } from "react";
import { useRouter } from "next/navigation"; // استخدم هذه المكتبة للتنقل بين الصفحات
import { regester } from "@/services/api";

export default function Register() {
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [password_confirmation, setPasswordCom] = useState("");

  const [successMessage, setSuccessMessage] = useState("");
  const [errorMessage, setErrorMessage] = useState("");
  const router = useRouter(); // استخدم الـ router

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const role ="student";
      console.log({ name, email, password, password_confirmation, role }); // تحقق من القيم

      const response = await regester({ name, email, password,password_confirmation,role }); // إرسال البيانات إلى API
      setSuccessMessage("User registered successfully. Please log in.");
      setErrorMessage(""); // إخفاء رسالة الخطأ
        // الانتقال إلى صفحة تسجيل الدخول بعد ثانية واحدة
      setTimeout(() => {
        router.push("/login"); // تغيير المسار إلى صفحة تسجيل الدخول
      }, 1000);
    } catch (error) {
      setErrorMessage(
        error.response?.data?.message || "Registration failed. Please try again."
      );
      setSuccessMessage(""); // إخفاء رسالة النجاح
    }
  };

  return (
    <div className="flex justify-center items-center h-screen bg-white dark:bg-gray-800">
      <form
        onSubmit={handleSubmit}
        className="bg-gray-100 dark:bg-gray-900 text-black dark:text-gray-200 p-6 rounded shadow-md max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg w-full"
      >
        <h2 className="text-2xl font-bold mb-4">Create an Account</h2>
        {successMessage && <p className="text-green-500 mb-4">{successMessage}</p>}
        {errorMessage && <p className="text-red-500 mb-4">{errorMessage}</p>}
        <div className="mb-4">
          <label htmlFor="name" className="block text-gray-700">
            Name
          </label>
          <input
            type="text"
            id="name"
            className="w-full p-2 border border-gray-300 rounded mt-1"
            value={name}
            onChange={(e) => setName(e.target.value)}
            required
          />
        </div>
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
           <label htmlFor="password" className="block text-gray-700">
            Password confirm
          </label>
          <input
            type="password"
            id="password_confirmation"
            className="w-full p-2 border border-gray-300 rounded mt-1"
            value={password_confirmation}
            onChange={(e) => setPasswordCom(e.target.value)}
            required
          />
        </div>
        <button
          type="submit"
          className="bg-gray-600 dark:bg-gray-800 text-white w-full p-2 rounded"
        >
          Register
        </button>
        <p className="mt-4 text-sm text-center">
          لديك حساب بالفعل؟{" "}
          <a
            href="/login"
            className="text-blue-500 hover:underline"
          >
            سجل الدخول
          </a>
        </p>
      </form>
    </div>
  );
}
