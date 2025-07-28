// Lấy các phần tử DOM
const container = document.querySelector('.container');
const registerBtn = document.querySelector('.register-btn');
const loginBtn = document.querySelector('.login-btn');

// Xử lý chuyển đổi giữa form đăng nhập và đăng ký
if (registerBtn && loginBtn && container) {
    registerBtn.addEventListener('click', () => {
        container.classList.add('active');
    });

    loginBtn.addEventListener('click', () => {
        container.classList.remove('active');
    });
}

// Xử lý khi trang load xong
document.addEventListener('DOMContentLoaded', function() {
    console.log('Trang auth đã load xong');
});

document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.querySelector('.form-box.login');
    const registerForm = document.querySelector('.form-box.register');
    const loginBtn = document.querySelector('.login-btn');
    const registerBtn = document.querySelector('.register-btn');

    loginBtn.addEventListener('click', function () {
        loginForm.classList.add('active');
        registerForm.classList.remove('active');
    });

    registerBtn.addEventListener('click', function () {
        registerForm.classList.add('active');
        loginForm.classList.remove('active');
    });
});
