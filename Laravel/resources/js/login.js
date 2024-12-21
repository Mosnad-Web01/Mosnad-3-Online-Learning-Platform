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

        axios.post('/api/login', data)
            .then(response => {

                const userRole = response.data.user.role; 
                if (userRole === 'Admin') {
                    window.location.href = '/admin/dashboard';  
                } else if (userRole === 'Instructor') {
                    window.location.href = '/instructor/dashboard'; 
                } 
                 else if (userRole === 'Student'){
                      window.location.href = '/';  // تحويل إلى لوحة تحكم أخرى للمستخدمين العاديين
                 }
            })
            .catch(error => {
                console.log(error);
                alert('Error: ' + error.response.data.message);
            });
    });
});
