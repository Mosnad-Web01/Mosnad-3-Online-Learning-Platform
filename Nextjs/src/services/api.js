// src/services/api.js

import axios from 'axios';
import {getToken } from '@/utils/auth'; // استيراد دالة needsAuth للتحقق من الحاجة إلى التوكن

const api = axios.create({
  baseURL: 'http://127.0.0.1:8000/api', // قاعدة الرابط الخاصة بـ API
  headers: {
    'Content-Type': 'application/json',
  },
});

// إضافة التوكن إلى الرؤوس في كل طلب
api.interceptors.request.use((config) => {
  const token = getToken();
  if (token) {
    config.headers['Authorization'] = `Bearer ${token}`;
  }
  return config;
});

export default api;





// الفئات (Categories)
export const fetchCategories = () => apiClient.get('/categories');
export const createCategory = (data) => apiClient.post('/categories', data);
export const updateCategory = (id, data) => apiClient.put(`/categories/${id}`, data);
export const deleteCategory = (id) => apiClient.delete(`/categories/${id}`);

// الكورسات (Courses)
export const fetchCourses = () => apiClient.get('/courses');
export const fetchCourseById = (id) => apiClient.get(`/courses/${id}`);
export const createCourse = (data) => apiClient.post('/courses', data);
export const updateCourse = (id, data) => apiClient.put(`/courses/${id}`, data);
export const deleteCourse = (id) => apiClient.delete(`/courses/${id}`);

// الدروس (Lessons)
export const fetchLessons = (courseId) => apiClient.get(`/courses/${courseId}/lessons`);
export const fetchLessonById = (courseId, lessonId) =>
  apiClient.get(`/courses/${courseId}/lessons/${lessonId}`);
export const createLesson = (courseId, data) =>
  apiClient.post(`/courses/${courseId}/lessons`, data);
export const updateLesson = (courseId, lessonId, data) =>
  apiClient.put(`/courses/${courseId}/lessons/${lessonId}`, data);
export const deleteLesson = (courseId, lessonId) =>
  apiClient.delete(`/courses/${courseId}/lessons/${lessonId}`);
