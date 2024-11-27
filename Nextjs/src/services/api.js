import axios from 'axios';

// إنشاء مثال لـ axios مع إعدادات افتراضية
const api = axios.create({
  baseURL: 'http://localhost:8000/api',
  withCredentials: true, // تأكد من إرسال الكوكيز مع الطلبات
});

// دالة مساعدة للحصول على التوكن إذا لم يكن موجودًا
const getCsrfToken = () => {
  return axios.get('http://localhost:8000/api/sanctum/csrf-cookie', {
    withCredentials: true, // إرسال الكوكيز مع الطلب
  }).then(() => {
    return document.cookie
      .split('; ')
      .find(row => row.startsWith('XSRF-TOKEN='))
      ?.split('=')[1];
  });
};

// تعيين التوكن XSRF بشكل افتراضي في رؤوس الطلبات
api.interceptors.request.use(async (config) => {
  // التحقق من وجود XSRF-TOKEN في الكوكيز
  let csrfToken = document.cookie
    .split('; ')
    .find(row => row.startsWith('XSRF-TOKEN='))
    ?.split('=')[1];


  // إذا لم يكن التوكن موجودًا، قم بطلبه وانتظره
  if (!csrfToken) {
    csrfToken = await getCsrfToken();
  }

  // إذا كان التوكن موجودًا، تعيينه في الرؤوس
  if (csrfToken) {
    config.headers['X-XSRF-TOKEN'] = decodeURIComponent(csrfToken);
  }

  // تعيين Content-Type إلى 'application/json' إذا لم يكن محددًا
  if (!config.headers['Content-Type']) {
    config.headers['Content-Type'] = 'application/json';
  }
  console.log("csrfToken:", csrfToken);
  
  return config;
}, (error) => {
  // معالجة الأخطاء في حال وجودها
  return Promise.reject(error);
});

// دوال التعامل مع API
export const loginUser = ({ email, password }) => {
  console.log("Email:", email);
console.log("Password:", password);

  return api.post('/login', { email, password }).then((response) => {
    // لا حاجة لتخزين التوكن في الكوكيز يدويًا، حيث يتولى Sanctum هذا الأمر
    return response;
  });
};

// دوال أخرى (أمثلة)...
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

// دوال إضافية للتعامل مع الأقسام الأخرى...
// (ابق الدوال الأخرى كما هي في الشيفرة الأصلية)


// الفئات (Categories)
export const fetchCategories = () => api.get('/categories');
export const createCategory = (data) => api.post('/categories', data);
export const updateCategory = (id, data) => api.put(`/categories/${id}`, data);
export const deleteCategory = (id) => api.delete(`/categories/${id}`);

// الكورسات (Courses)
export const fetchCourses = () => api.get('/courses')
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
