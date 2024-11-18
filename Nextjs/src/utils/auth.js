// src/utils/auth.js
// import mockData from '../data/mockData.js';

// export function loginUser(username, password) {
//   const user = mockData.users.find(
//     (user) => user.name === username && user.password === password
//   );

//   if (user) {
//     user.isLoggedIn = true; 
//     localStorage.setItem('loggedInUser', JSON.stringify(user)); 
//     console.log(`تم تسجيل الدخول بنجاح. مرحبًا، ${user.name}!`);
//     return user;
//   } else {
//     console.log('فشل تسجيل الدخول: تحقق من اسم المستخدم أو كلمة المرور.');
//     return null;
//   }
// }

// export function logoutUser(userId) {
//   const user = mockData.users.find((user) => user.id === userId);

//   if (user && user.isLoggedIn) {
//     user.isLoggedIn = false; // تحديث حالة تسجيل الخروج
//     localStorage.removeItem('loggedInUser'); // إزالة معلومات المستخدم من localStorage
//     console.log(`${user.name} تم تسجيل الخروج بنجاح.`);
//   } else {
//     console.log('المستخدم غير مسجل الدخول.');
//   }
// }


// utils/auth.js
import api from '../services/api';
import { fetchData } from '@/services/fetchData';

// دالة تسجيل الدخول باستخدام fetchData
export const loginUser = async (username, password, router) => {
  return await fetchData('/login', 'POST', { email: username, password }, router);
};

// دالة جلب بيانات المستخدم باستخدام fetchData
export const fetchUserData = async (router) => {
  const userData = await fetchData('/user-profile', 'GET', null, router);
  return userData ? userData.user : null;
};


export const isAuthenticated = async () => {
  const token = localStorage.getItem('token');
  if (!token) return false;

  try {
    const response = await api.get('/authenticated-user', { headers: { Authorization: `Bearer ${token}` } });
    return response.status === 200; // إذا كانت الاستجابة ناجحة
  } catch (error) {
    console.error('Error checking authentication', error);
    return false;
  }
};

// دالة للتحقق مما إذا كان الرابط يحتاج توكن أم لا
export const needsAuth = (url) => {
  const protectedRoutes = ['/profile', '/settings', '/dashboard']; // استبدل هذه الروابط بما يتناسب معك
  return protectedRoutes.includes(url);
};

// دالة لاسترجاع التوكن
export const getToken = () => {
  return localStorage.getItem('token');
};

// دالة لتخزين التوكن
export const setToken = (token) => {
  localStorage.setItem('token', token);
};

// دالة لإزالة التوكن
export const removeToken = () => {
  localStorage.removeItem('token');
};
