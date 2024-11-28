import { loginStudent } from '../services/api'; // استيراد وظيفة تسجيل الدخول من API

let loggedInUser = null; // تتبع حالة تسجيل الدخول في الذاكرة

export async function loginUser(username, password) {
  try {
    const response = await loginStudent({ username, password }); // إرسال بيانات تسجيل الدخول
    loggedInUser = response.data.user; // حفظ بيانات المستخدم في الذاكرة
    console.log(`تم تسجيل الدخول بنجاح. مرحبًا، ${loggedInUser.name}!`);
    return loggedInUser;
  } catch (error) {
    console.error('فشل تسجيل الدخول: تحقق من اسم المستخدم أو كلمة المرور.', error.response?.data || error.message);
    return null;
  }
}

export function logoutUser() {
  if (loggedInUser) {
    console.log(`${loggedInUser.name} تم تسجيل الخروج بنجاح.`);
    loggedInUser = null; // إزالة بيانات المستخدم من الذاكرة
  } else {
    console.log('المستخدم غير مسجل الدخول.');
  }
}

export function getLoggedInUser() {
  return loggedInUser; // إرجاع حالة تسجيل الدخول
}
