import axios from 'axios';

// دالة للحصول على التوكن CSRF
export const getCsrfToken = async () => {
  // تحقق من وجود التوكن في الكوكيز
  let csrfToken = document.cookie
    .split('; ')
    .find(row => row.startsWith('XSRF-TOKEN='))
    ?.split('=')[1];
  
  // إذا لم يكن التوكن موجودًا، قم بطلبه
  if (!csrfToken) {
    await axios.get('http://localhost:8000/api/sanctum/csrf-cookie', {
      withCredentials: true,
    });

    // بعد الطلب، قم بفحص التوكن مرة أخرى
    csrfToken = document.cookie
      .split('; ')
      .find(row => row.startsWith('XSRF-TOKEN='))
      ?.split('=')[1];
  }
  
  // إعادة التوكن إذا كان موجودًا
  return csrfToken;
};
// // دالة مساعدة للحصول على التوكن إذا لم يكن موجودًا
// const getCsrfToken = () => {
//   return axios.get('http://localhost:8000/api/sanctum/csrf-cookie', {
//     withCredentials: true, // إرسال الكوكيز مع الطلب
//   }).then(() => {
//     return document.cookie
//       .split('; ')
//       .find(row => row.startsWith('XSRF-TOKEN='))
//       ?.split('=')[1];
//   });
// };

// // تعيين التوكن XSRF بشكل افتراضي في رؤوس الطلبات
// api.interceptors.request.use(async (config) => {
//   // التحقق من وجود XSRF-TOKEN في الكوكيز
//   console.log('front csrfToken:', csrfToken); // عرض التوكن في وحدة التحكم

//   let csrfToken = document.cookie
//     .split('; ')
//     .find(row => row.startsWith('XSRF-TOKEN='))
//     ?.split('=')[1];

//   console.log('front csrfToken:', csrfToken); // عرض التوكن في وحدة التحكم

//   // إذا لم يكن التوكن موجودًا، قم بطلبه وانتظره
//   if (!csrfToken) {
//     csrfToken = await getCsrfToken();
//   }

//   // إذا كان التوكن موجودًا، تعيينه في الرؤوس
//   if (csrfToken) {
//     config.headers['X-XSRF-TOKEN'] = decodeURIComponent(csrfToken);
//   }

//   // تعيين Content-Type إلى 'application/json' إذا لم يكن محددًا
//   if (!config.headers['Content-Type']) {
//     config.headers['Content-Type'] = 'application/json';
//   }

//   return config;
// }, (error) => {
//   // معالجة الأخطاء في حال وجودها
//   return Promise.reject(error);
// });

