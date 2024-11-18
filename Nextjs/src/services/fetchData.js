import api from './api';
import { needsAuth,getToken } from '@/utils/auth'; // استيراد دالة needsAuth للتحقق من الحاجة إلى التوكن

export const fetchData = async (url, method = 'GET', data = null, router = null) => {
  // التحقق مما إذا كان الرابط يتطلب توكن
  const token = getToken();
  const requiresAuth = needsAuth(url);

  if (requiresAuth && !token) {
    // إذا كان الرابط يتطلب توكن والمستخدم ليس لديه توكن، أعد توجيهه إلى صفحة تسجيل الدخول
    if (router) router.push('/login');
    console.log('Redirecting to login page...');
    return null;
  }

  // إعداد الخيارات الخاصة بالطلب
  const headers = {
    'Content-Type': 'application/json',
    ...(token && requiresAuth ? { 'Authorization': `Bearer ${token}` } : {}),
  };

  try {
    const options = {
      method,
      url,
      headers,
      ...(data && { data }), // إذا كانت هناك بيانات للإرسال
    };

    const response = await api(options);
console.log('res: ',response);
    if (response.data && response.data.success) {
      return response.data; // إرجاع بيانات الاستجابة
    } else {
      throw new Error(response.data.message || 'Unknown error');
    }
  } catch (error) {
    console.error('Error occurred during the request:', error);
    if (router) {
      router.push('/login'); // إعادة التوجيه إلى صفحة تسجيل الدخول إذا كانت هناك مشكلة في المصادقة
    }
    return null;
  }
};
