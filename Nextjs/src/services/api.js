import axios from 'axios';

// ضبط العنوان الأساسي للـ API
const apiClient = axios.create({
  baseURL: 'http://127.0.0.1:8000/api',
  headers: {
    'Content-Type': 'application/json',
  },
});

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
