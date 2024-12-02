document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');

    loginForm.addEventListener('submit', function(e) {
        e.preventDefault(); // لمنع الإرسال التقليدي للنموذج

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const remember = document.getElementById('remember').checked;

        // إعداد البيانات لإرسالها
        const data = {
            email: email,
            password: password,
            remember: remember
        };

        // إرسال الطلب باستخدام Axios
        axios.post('/api/login', data)
            .then(response => {
                console.log('Response:', response);

                // بعد نجاح تسجيل الدخول، استرجاع الدور من الاستجابة
                const userRole = response.data.user.role; // تأكد من أن الدور يتم إرجاعه في الاستجابة

        // تحقق مما إذا كانت القيمة موجودة قبل استخدامها
        if (userRole) {
            console.log('b ',userRole); } // طباعة الدور لتأكيد أنه تم استرجاعه بشكل صحيح

                // التوجيه بناءً على الدور
                if (userRole === 'Admin') {
                    window.location.href = '/admin/dashboard';  // تحويل إلى لوحة تحكم المدير
                } else if (userRole === 'Instructor') {
                    window.location.href = '/instructor/dashboard';  // تحويل إلى لوحة تحكم المدرب
                } else {
                    console.log(userRole);

                    // window.location.href = '/login';  // تحويل إلى لوحة تحكم أخرى للمستخدمين العاديين
                }
            })
            .catch(error => {
                console.log(error);
                alert('Error: ' + error.response.data.message);
            });
    });
});
