<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gheday-Trang chủ</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/auth.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="img/logo_gheday.png" alt="gheday Logo" height="50">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="bi bi-house me-1"></i>Trang Chủ
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main style="margin-top: 76px;">
        <!-- Auth Container -->
        <div class="auth-container">
            <div class="container">
                <div class="row justify-content-center align-items-center min-vh-100">
                    <div class="col-lg-10">
                        <div class="auth-wrapper">
                            <!-- Logo Section -->
                            <div class="logo-section text-center mb-4">
                                <img src="img/logo_gheday.png" alt="gheday Logo" class="auth-logo">
                                <h1 class="auth-title">Chào mừng đến với gheday</h1>
                                <p class="auth-subtitle">Đặt vé tàu chợ nổi Cần Thơ nhanh chóng và tiện lợi</p>
                            </div>

                            <!-- Auth Forms -->
                            <div class="auth-forms">
                                <div class="row">
                                    <!-- Login Form -->
                                    <div class="col-lg-6">
                                        <div class="form-container login-form">
                                            <div class="form-header">
                                                <h2><i class="bi bi-box-arrow-in-right me-2"></i>Đăng Nhập</h2>
                                                <p>Đăng nhập để tiếp tục</p>
                                            </div>

                                            <?php if (isset($errors) && !empty($errors)): ?>
                                                <div class="alert alert-danger">
                                                    <?php foreach ($errors as $error): ?>
                                                        <div><i class="bi bi-exclamation-triangle me-2"></i><?php echo htmlspecialchars($error); ?></div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>

                                            <form action="index.php?controller=auth&action=login" method="POST" id="loginForm">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">
                                                        <i class="bi bi-person me-2"></i>Tên đăng nhập
                                                    </label>
                                                    <input type="text" class="form-control" name="username" placeholder="Nhập tên đăng nhập" required>
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label class="form-label">
                                                        <i class="bi bi-lock me-2"></i>Mật khẩu
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" name="password" id="loginPassword" placeholder="Nhập mật khẩu" required>
                                                        <button class="btn btn-outline-secondary" type="button" id="toggleLoginPassword">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" id="rememberMe">
                                                    <label class="form-check-label" for="rememberMe">
                                                        Ghi nhớ đăng nhập
                                                    </label>
                                                </div>

                                                <button type="submit" class="btn btn-primary w-100 mb-3">
                                                    <i class="bi bi-box-arrow-in-right me-2"></i>Đăng Nhập
                                                </button>

                                                <div class="text-center">
                                                    <a href="#" class="text-decoration-none">Quên mật khẩu?</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Register Form -->
                                    <div class="col-lg-6">
                                        <div class="form-container register-form">
                                            <div class="form-header">
                                                <h2><i class="bi bi-person-plus me-2"></i>Đăng Ký</h2>
                                                <p>Tạo tài khoản mới</p>
                                            </div>

                                            <form action="index.php?controller=auth&action=register" method="POST" id="registerForm">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">
                                                                <i class="bi bi-person me-2"></i>Tên đăng nhập
                                                            </label>
                                                            <input type="text" class="form-control" name="username" placeholder="Tên đăng nhập" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">
                                                                <i class="bi bi-person-badge me-2"></i>Họ tên
                                                            </label>
                                                            <input type="text" class="form-control" name="fullname" placeholder="Họ tên đầy đủ" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">
                                                        <i class="bi bi-envelope me-2"></i>Email
                                                    </label>
                                                    <input type="email" class="form-control" name="email" placeholder="Email của bạn" required>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">
                                                                <i class="bi bi-telephone me-2"></i>Số điện thoại
                                                            </label>
                                                            <input type="tel" class="form-control" name="phone" placeholder="Số điện thoại" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">
                                                                <i class="bi bi-geo-alt me-2"></i>Địa chỉ
                                                            </label>
                                                            <input type="text" class="form-control" name="address" placeholder="Địa chỉ">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">
                                                        <i class="bi bi-lock me-2"></i>Mật khẩu
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" name="password" id="registerPassword" placeholder="Mật khẩu" required>
                                                        <button class="btn btn-outline-secondary" type="button" id="toggleRegisterPassword">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label class="form-label">
                                                        <i class="bi bi-lock-fill me-2"></i>Xác nhận mật khẩu
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" name="confirm_password" id="confirmPassword" placeholder="Nhập lại mật khẩu" required>
                                                        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                                                    <label class="form-check-label" for="agreeTerms">
                                                        Tôi đồng ý với <a href="#" class="text-decoration-none">Điều khoản sử dụng</a> và <a href="#" class="text-decoration-none">Chính sách bảo mật</a>
                                                    </label>
                                                </div>

                                                <button type="submit" class="btn btn-success w-100">
                                                    <i class="bi bi-person-plus me-2"></i>Đăng Ký
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Password toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Login password toggle
            const toggleLoginPassword = document.getElementById('toggleLoginPassword');
            const loginPassword = document.getElementById('loginPassword');
            
            if (toggleLoginPassword && loginPassword) {
                toggleLoginPassword.addEventListener('click', function() {
                    const type = loginPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                    loginPassword.setAttribute('type', type);
                    this.querySelector('i').classList.toggle('bi-eye');
                    this.querySelector('i').classList.toggle('bi-eye-slash');
                });
            }

            // Register password toggle
            const toggleRegisterPassword = document.getElementById('toggleRegisterPassword');
            const registerPassword = document.getElementById('registerPassword');
            
            if (toggleRegisterPassword && registerPassword) {
                toggleRegisterPassword.addEventListener('click', function() {
                    const type = registerPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                    registerPassword.setAttribute('type', type);
                    this.querySelector('i').classList.toggle('bi-eye');
                    this.querySelector('i').classList.toggle('bi-eye-slash');
                });
            }

            // Confirm password toggle
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const confirmPassword = document.getElementById('confirmPassword');
            
            if (toggleConfirmPassword && confirmPassword) {
                toggleConfirmPassword.addEventListener('click', function() {
                    const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                    confirmPassword.setAttribute('type', type);
                    this.querySelector('i').classList.toggle('bi-eye');
                    this.querySelector('i').classList.toggle('bi-eye-slash');
                });
            }

            // Password confirmation validation
            const registerForm = document.getElementById('registerForm');
            if (registerForm) {
                registerForm.addEventListener('submit', function(e) {
                    const password = registerPassword.value;
                    const confirm = confirmPassword.value;
                    
                    if (password !== confirm) {
                        e.preventDefault();
                        alert('Mật khẩu xác nhận không khớp!');
                        return false;
                    }
                });
            }
        });
    </script>
</body>
</html>
