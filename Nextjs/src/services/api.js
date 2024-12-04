
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
// تحليل الكوكي للحصول على قيمة معينة
function getCookie(name) {
  const cookies = document.cookie.split('; ');
  const tokenCookie = cookies.find(cookie => cookie.startsWith(`${name}=`));
  return tokenCookie ? tokenCookie.split('=')[1] : null;
}
// تعيين التوكن XSRF بشكل افتراضي في رؤوس الطلبات
api.interceptors.request.use(async (config) => {
  
    let csrfToken = getCookie('XSRF-TOKEN'); // قراءة الكوكي "XSRF-TOKEN"
    //let token = getCookie('token'); // قراءة الكوكي "token"

  // إذا لم يكن التوكن موجودًا، قم بطلبه وانتظره
  if (!csrfToken) {
    csrfToken = await getCsrfToken();
  }

  // إذا كان التوكن موجودًا، تعيينه في الرؤوس
  if (csrfToken) {
    console.log('csrfToken ',csrfToken);

    config.headers['X-XSRF-TOKEN'] = decodeURIComponent(csrfToken);
  }
  // if (token) {
  //   config.headers['Authorization'] = `Bearer ${decodeURIComponent(token)}`; // إضافة التوكن للهيدر
  // }
  // // تعيين Content-Type إلى 'application/json' إذا لم يكن محددًا
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
export const fetchUserprofile = () => api.get(`/user-profiles`);
export const fetchCurrentUser = () => api.get('/users');

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



// import axios from "axios";

// // ضبط العنوان الأساسي للـ API
// const apiClient = axios.create({
//   baseURL: "http://127.0.0.1:8000/api",
//   headers: {
//     "Content-Type": "application/json",
//   },
// });

// // الفئات (Categories)
// export const fetchCategories = () => apiClient.get("/categories");
// export const createCategory = (data) => apiClient.post("/categories", data);
// export const updateCategory = (id, data) =>
//   apiClient.put(`/categories/${id}`, data);
// export const deleteCategory = (id) => apiClient.delete(`/categories/${id}`);

// // الكورسات (Courses)
// export const fetchCourses = () => apiClient.get("/courses");
// export const fetchCourseById = (id) => apiClient.get(`/courses/${id}`);
// export const createCourse = (data) => apiClient.post("/courses", data);
// export const updateCourse = (id, data) => apiClient.put(`/courses/${id}`, data);
// export const deleteCourse = (id) => apiClient.delete(`/courses/${id}`);

// // الدروس (Lessons)
// export const fetchLessons = (courseId) =>
//   apiClient.get(`/courses/${courseId}/lessons`);
// export const fetchLessonById = (courseId, lessonId) =>
//   apiClient.get(`/courses/${courseId}/lessons/${lessonId}`);
// export const createLesson = (courseId, data) =>
//   apiClient.post(`/courses/${courseId}/lessons`, data);
// export const updateLesson = (courseId, lessonId, data) =>
//   apiClient.put(`/courses/${courseId}/lessons/${lessonId}`, data);
// export const deleteLesson = (courseId, lessonId) =>
//   apiClient.delete(`/courses/${courseId}/lessons/${lessonId}`);

// // التسجيلات (Enrollments)
// export const fetchEnrollments = () => apiClient.get("/enrollments");
// export const createEnrollment = (data) => {
//   const token = localStorage.getItem("token");
//   return apiClient.post("/enrollments", data, {
//     headers: {
//       Authorization: `Bearer ${token}`,
//     },
//   });
// };

// export const updateEnrollment = (id, data) => {
//   const token = localStorage.getItem("token");
//   return apiClient.put(`/enrollments/${id}`, data, {
//     headers: {
//       Authorization: `Bearer ${token}`,
//     },
//   });
// };
// export const deleteEnrollment = (id) => apiClient.delete(`/enrollments/${id}`);
// export const checkEnrollment = (courseId, studentId) =>
//   apiClient.post(`/enrollments/check/${courseId}`, { student_id: studentId });

// // الطلاب (Students)
// export const registerStudent = (data) =>
//   apiClient.post("/students/register", data);
// export const loginUser = (data) => apiClient.post("/students/login", data);
// export const logoutStudent = async () => {
//   try {
//     const token = localStorage.getItem("token"); // أو من أي مصدر آخر يخزن فيه التوكن
//     await apiClient.post(
//       "/students/logout",
//       {},
//       {
//         headers: {
//           Authorization: `Bearer ${token}`,
//         },
//       }
//     );
//     // يمكنك أيضًا مسح التوكن من التخزين المحلي بعد تسجيل الخروج
//     localStorage.removeItem("token");
//   } catch (error) {
//     console.error("Failed to logout:", error);
//     throw error;
//   }
// };
// export const fetchStudentById = (id) => apiClient.get(`/students/${id}`);
// export const updateStudent = (id, data) =>
//   apiClient.put(`/students/${id}`, data);
// export const deleteStudent = (id) => apiClient.delete(`/students/${id}`);
// export const getCurrentStudent = async () => {
//   try {
//     const token = localStorage.getItem("token"); // أو من أي مصدر آخر يخزن فيه التوكن
//     const response = await apiClient.get("/students/me", {
//       headers: {
//         Authorization: `Bearer ${token}`,
//       },
//     });
//     return response.data;
//   } catch (error) {
//     console.error("Failed to fetch current student:", error);
//     throw error;
//   }
// };

// // إكمالات الدروس (Lesson Completions)
// export const fetchLessonCompletions = () =>
//   apiClient.get("/lesson-completions");
// export const createLessonCompletion = (data) =>
//   apiClient.post("/lesson-completions", data);
// export const deleteLessonCompletion = (id) =>
//   apiClient.delete(`/lesson-completions/${id}`);

// // المدفوعات (Payments)
// export const createPayment = (paymentData) => {
//   return apiClient.post("/payments", paymentData);
// };

// // الحصول على جميع التسجيلات
// export const fetchAllCourseUsers = () => apiClient.get("/course-user");

// // عرض تسجيل معين حسب ID
// export const fetchCourseUserById = (id) => apiClient.get(`/course-user/${id}`);

// // إنشاء تسجيل جديد
// export const createCourseUser = (data) => apiClient.post("/course-user", data);

// // تحديث تسجيل معين
// export const updateCourseUser = (id, data) =>
//   apiClient.put(`/course-user/${id}`, data);

// // حذف تسجيل معين
// export const deleteCourseUser = (id) => apiClient.delete(`/course-user/${id}`);

// // البحث عن التسجيل بناءً على user_id و course_id
// export const fetchCourseUser = (userId, courseId) =>
//   apiClient.get(`/course-users?user_id=${userId}&course_id=${courseId}`);
