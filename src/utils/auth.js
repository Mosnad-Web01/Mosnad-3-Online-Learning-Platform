// src/utils/auth.js
import mockData from '../data/mockData.js';

export function loginUser(username, password) {
  const user = mockData.users.find(
    (user) => user.name === username && user.password === password
  );

  if (user) {
    user.isLoggedIn = true; 
    localStorage.setItem('loggedInUser', JSON.stringify(user)); 
    console.log(`تم تسجيل الدخول بنجاح. مرحبًا، ${user.name}!`);
    return user;
  } else {
    console.log('فشل تسجيل الدخول: تحقق من اسم المستخدم أو كلمة المرور.');
    return null;
  }
}

export function logoutUser(userId) {
  const user = mockData.users.find((user) => user.id === userId);

  if (user && user.isLoggedIn) {
    user.isLoggedIn = false; // تحديث حالة تسجيل الخروج
    localStorage.removeItem('loggedInUser'); // إزالة معلومات المستخدم من localStorage
    console.log(`${user.name} تم تسجيل الخروج بنجاح.`);
  } else {
    console.log('المستخدم غير مسجل الدخول.');
  }
}
