import axios from 'axios';

// إنشاء مثال لـ axios مع إعدادات افتراضية
const api = axios.create({
  baseURL: 'http://localhost:8000/api',
  withCredentials: true, // تأكد من إرسال الكوكيز مع الطلبات
});

// دالة مساعدة للحصول على التوكن إذا لم يكن موجودًا
export const getCsrfToken = async () => {
  try {
    // Fetch the CSRF token from the backend
    await axios.get('http://localhost:8000/api/sanctum/csrf-cookie', {
      withCredentials: true, // Send cookies with the request
    });

    // Check if the environment is client-side
    if (typeof window !== 'undefined') {
      console.log('Running on the client side');
      const cookieString = document.cookie;
      const xsrfCookie = cookieString
        .split('; ')
        .find((row) => row.startsWith('XSRF-TOKEN='));
      return xsrfCookie ? xsrfCookie.split('=')[1] : null;
    } else {
      console.log('Running on the server side');
      throw new Error('This function does not support server-side execution.');
    }
  } catch (error) {
    console.error('Error getting CSRF token:', error);
    return null;
  }
};

// دالة للحصول على الكوكيز
export const getCookie = (name) => {
  if (typeof document !== 'undefined') {
    const cookies = document.cookie.split('; ');
    const tokenCookie = cookies.find(cookie => cookie.startsWith(`${name}=`));
    return tokenCookie ? tokenCookie.split('=')[1] : null;
  }
  return null;
};

// تعيين التوكن XSRF بشكل افتراضي في رؤوس الطلبات
api.interceptors.request.use(async (config) => {
  let csrfToken = getCookie('XSRF-TOKEN');
  if (!csrfToken) {
    csrfToken = await getCsrfToken();
  }
  if (csrfToken) {
    config.headers['X-XSRF-TOKEN'] = decodeURIComponent(csrfToken);
  }

  if (!config.headers['Content-Type']) {
    config.headers['Content-Type'] = 'application/json';
  }
  console.log("csrfToken:", csrfToken);

  return config;
}, (error) => {
  return Promise.reject(error);
});

// دوال التعامل مع المستخدمين
export const loginUser = ({ email, password }) => {
  return api.post('/login', { email, password }).then((response) => {
    return response;
  });
};
export const registerStudent = async ({ name, email, password, csrfToken }) => {
  return api.post('/register', { name, email, password }, {
    headers: {
      'X-XSRF-TOKEN': csrfToken,
    }
  }).then((response) => {
    return response.data;
  });
};

export const regester = ({ name, email, password, password_confirmation, role }) => {
  return api.post('/register', { name, email, password, password_confirmation, role }) // إرسال البيانات مباشرة
  .then((response) => {
    return response;
  });
};

export const fetchUserprofile = () => api.get(`/user-profiles`);

export const fetchCurrentUser = () => api.get('/users');

export const logout = async () => {
  try {
    console.log('Logout ');

    const response = await api.post('/logout');
    console.log('Logout response:', response.data);
    return response.data;
  } catch (error) {
    console.error('Logout error:', error);
    throw error;
  }
};

// التعامل مع الفئات (Categories)
export const fetchCategories = () => api.get('/categories');
export const createCategory = (data) => api.post('/categories', data);
export const updateCategory = (id, data) => api.put(`/categories/${id}`, data);
export const deleteCategory = (id) => api.delete(`/categories/${id}`);

// التعامل مع الكورسات (Courses)

export const fetchCourseUser = () => api.get('/courses');

export const fetchCourses = () => api.get('/courses');
export const fetchCourseById = (id) => api.get(`/courses/${id}`);
export const createCourse = (data) => api.post('/courses', data);
export const updateCourse = (id, data) => api.put(`/courses/${id}`, data);
export const deleteCourse = (id) => api.delete(`/courses/${id}`);

// التعامل مع الدروس (Lessons)
export const fetchLessons = (courseId) => api.get(`/courses/${courseId}/lessons`);
export const fetchLessonById = (courseId, lessonId) =>
  api.get(`/courses/${courseId}/lessons/${lessonId}`);
export const createLesson = (courseId, data) =>
  api.post(`/courses/${courseId}/lessons`, data);
export const updateLesson = (courseId, lessonId, data) =>
  api.put(`/courses/${courseId}/lessons/${lessonId}`, data);
export const deleteLesson = (courseId, lessonId) =>
  api.delete(`/courses/${courseId}/lessons/${lessonId}`);

// التعامل مع التسجيلات (Enrollments)

export const createEnrollment = (data) =>
  api.post(`/enrollments/courses/${data.courseId}/enroll`, data);

export const updateProgress = (data) =>
  api.patch(`/enrollments/courses/${data.courseId}/progress`, data);

export const fetchStudentEnrollments = () =>
  api.get('/enrollments/courses');

export const fetchEnrollmentByCourseId = (courseId) =>
  api.get(`/enrollments/courses/${courseId}`);

// التعامل مع إكمالات الدروس (Lesson Completions)
export const fetchLessonCompletions = () => api.get('/lesson-completions');
export const createLessonCompletion = (data) => api.post('/lesson-completions', data);
export const deleteLessonCompletion = (id) => api.delete(`/lesson-completions/${id}`);

// التعامل مع المدفوعات (Payments)
export const createPayment = (paymentData) => api.post('/payments', paymentData);


export default api;
