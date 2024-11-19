
import api from './api';
import { needsAuth,getToken } from '@/utils/auth'; // استيراد دالة needsAuth للتحقق من الحاجة إلى التوكن

export const fetchData = async (url, method = 'GET', data = null, router = null) => {
  // التحقق مما إذا كان الرابط يتطلب توكن
  console.log('techdata',data);
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
    console.log('data responses: ',response.data);
    console.log('data responses access_token: ',response.data.access_token);

    if (response.data && response.data.access_token) {
        console.log('fetach data responses: ',response);

      return response.data; // إرجاع بيانات الاستجابة
    } else {
      throw new Error(response.data.message || 'Unknown error');
    }
  } catch (error) {
    //console.error('Error occurred during the request:', error);
    //setError('Incorrect username or password. Please check your credentials and try again.');
     
    if (router) {
      router.push('/login'); // إعادة التوجيه إلى صفحة تسجيل الدخول إذا كانت هناك مشكلة في المصادقة
    }
    return null;
  }
};
