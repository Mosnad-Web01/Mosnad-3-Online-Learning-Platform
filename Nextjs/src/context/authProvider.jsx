import axios from 'axios';

// دالة للحصول على التوكن من الخادم باستخدام `axios`
const getCsrfToken = async () => {
  try {
    await axios.get('http://localhost:8000/api/sanctum/csrf-cookie', {
      withCredentials: true, // إرسال الكوكيز مع الطلب
    });
    return true;
  } catch (error) {
    console.error("Failed to fetch CSRF token:", error);
    return false;
  }
};

export async function getServerSideProps(context) {
  const { req } = context;

  // التحقق من المستخدم
  const user = req.cookies.user ? JSON.parse(req.cookies.user) : null;

  // إذا لم يكن المستخدم موجودًا، تحقق من CSRF token
  if (!user) {
    const csrfSuccess = await getCsrfToken();

    if (!csrfSuccess) {
      // إذا فشل الحصول على CSRF Token، يمكنك إجراء إعادة توجيه أو إرجاع بيانات مختلفة
      return {
        redirect: {
          destination: '/login',
          permanent: false,
        },
      };
    }
  }

  return {
    props: {
      user,
    },
  };
}
