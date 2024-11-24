import axios from 'axios';

// إنشاء كائن API باستخدام axios
const api = axios.create({
  baseURL: 'http://127.0.0.1:8000/api', // قاعدة الرابط الخاصة بـ API
  headers: {
    'Content-Type': 'application/json',
  },
  withCredentials: true, // هام للسماح بإرسال الكوكيز عبر النطاقات
});

// إضافة interceptor للتحقق من الطلبات
api.interceptors.request.use(
  (config) => {
    console.log('Interceptor triggered for URL:', config.url);
    return config;
  },
  (error) => {
    console.error('Error in request interceptor:', error);
    return Promise.reject(error);
  }
);

// دوال التعامل مع API
export const loginUser = ({ email, password }) => api.post('/login', { email, password });
export const fetchUserprofile = (id) => api.get(`/user-profile/${id}`);
export const fetchCurrentUser = () => api.get('/user');

// تسجيل الخروج
export const logout = async () => {
  try {
    const response = await api.post('/logout');
    console.log('Logout response:', response.data);
    return response.data;
  } catch (error) {
    console.error('Logout error:', error);
    throw error;
  }
};

// الفئات (Categories)
export const fetchCategories = () => api.get('/categories');
export const createCategory = (data) => api.post('/categories', data);
export const updateCategory = (id, data) => api.put(`/categories/${id}`, data);
export const deleteCategory = (id) => api.delete(`/categories/${id}`);

// الكورسات (Courses)
export const fetchCourses = () => api.get('/courses');
export const fetchCourseById = (id) => api.get(`/courses/${id}`);
export const createCourse = (data) => api.post('/courses', data);
export const updateCourse = (id, data) => api.put(`/courses/${id}`, data);
export const deleteCourse = (id) => api.delete(`/courses/${id}`);

// الدروس (Lessons)
export const fetchLessons = (courseId) => api.get(`/courses/${courseId}/lessons`);
export const fetchLessonById = (courseId, lessonId) =>
  api.get(`/courses/${courseId}/lessons/${lessonId}`);
export const createLesson = (courseId, data) =>
  api.post(`/courses/${courseId}/lessons`, data);
export const updateLesson = (courseId, lessonId, data) =>
  api.put(`/courses/${courseId}/lessons/${lessonId}`, data);
export const deleteLesson = (courseId, lessonId) =>
  api.delete(`/courses/${courseId}/lessons/${lessonId}`);

// التسجيلات (Enrollments)
export const fetchEnrollments = () => api.get('/enrollments');
export const fetchEnrollmentById = (id) => api.get(`/enrollments/${id}`);
export const createEnrollment = (data) => api.post('/enrollments', data);
export const updateEnrollment = (id, data) => api.put(`/enrollments/${id}`, data);
export const deleteEnrollment = (id) => api.delete(`/enrollments/${id}`);

// إكمالات الدروس (Lesson Completions)
export const fetchLessonCompletions = () => api.get('/lesson-completions');
export const createLessonCompletion = (data) => api.post('/lesson-completions', data);
export const deleteLessonCompletion = (id) => api.delete(`/lesson-completions/${id}`);

// المدفوعات (Payments)
export const createPayment = (paymentData) => api.post('/payments', paymentData);

export default api;
