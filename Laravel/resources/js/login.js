// login.js
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
                // بعد نجاح تسجيل الدخول، قم بتحويل المستخدم أو عرض رسالة
                window.location.href = '/redirect';  // تحويل إلى لوحة تحكم المدير
            })
            .catch(error => {
                console.log(error);
                alert('Error: ' + error.response.data.message);
            });
    });
});
