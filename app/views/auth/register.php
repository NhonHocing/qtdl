<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký - gheday</title>
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
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=auth&action=login">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Đăng Nhập
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main style="margin-top: 76px;">
        <!-- Register Container -->
        <div class="auth-container">
            <div class="container">
                <div class="row justify-content-center align-items-center min-vh-100">
                    <div class="col-lg-8 col-md-10">
                        <div class="auth-wrapper">
                            <!-- Logo Section -->
                            <div class="logo-section text-center mb-4">
                                <img src="img/logo_gheday.png" alt="gheday Logo" class="auth-logo">
                                <h1 class="auth-title">Đăng Ký</h1>
                                <p class="auth-subtitle">Tạo tài khoản mới để trải nghiệm dịch vụ tuyệt vời</p>
                            </div>

                            <!-- Register Form -->
                            <div class="form-container register-form">
                                <div class="form-header">
                                    <h2><i class="bi bi-person-plus me-2"></i>Tạo Tài Khoản Mới</h2>
                                    <p>Điền thông tin cá nhân của bạn</p>
                                </div>

                                <?php if (isset($errors) && !empty($errors)): ?>
                                    <div class="alert alert-danger">
                                        <?php foreach ($errors as $error): ?>
                                            <div><i class="bi bi-exclamation-triangle me-2"></i><?php echo htmlspecialchars($error); ?></div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <form action="index.php?controller=auth&action=register" method="POST" id="registerForm">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">
                                                    <i class="bi bi-person me-2"></i>Tên đăng nhập <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" name="username" placeholder="Tên đăng nhập" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">
                                                    <i class="bi bi-person-badge me-2"></i>Họ tên <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" name="fullname" placeholder="Họ tên đầy đủ" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">
                                            <i class="bi bi-envelope me-2"></i>Email <span class="text-danger">*</span>
                                        </label>
                                        <input type="email" class="form-control" name="email" placeholder="Email của bạn" required>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">
                                                    <i class="bi bi-telephone me-2"></i>Số điện thoại <span class="text-danger">*</span>
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
                                            <i class="bi bi-lock me-2"></i>Mật khẩu <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" name="password" id="registerPassword" placeholder="Mật khẩu (tối thiểu 6 ký tự)" required>
                                            <button class="btn btn-outline-secondary" type="button" id="toggleRegisterPassword">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        <small class="form-text text-muted">Mật khẩu phải có ít nhất 6 ký tự</small>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="form-label">
                                            <i class="bi bi-lock-fill me-2"></i>Xác nhận mật khẩu <span class="text-danger">*</span>
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
                                            Tôi đồng ý đăng ký với các thông tin trên <span class="text-danger">*</span>
                                        </label>
                                    </div>

                                    <button type="submit" class="btn btn-success w-100 mb-3">
                                        <i class="bi bi-person-plus me-2"></i>Đăng Ký
                                    </button>
                                </form>

                                <!-- Divider -->
                                <div class="divider my-4">
                                    <span>hoặc</span>
                                </div>

                                <!-- Login Link -->
                                <div class="text-center">
                                    <p class="mb-0">Đã có tài khoản? 
                                        <a href="index.php?controller=auth&action=login" class="text-decoration-none fw-bold">Đăng nhập ngay</a>
                                    </p>
                                </div>
                            </div>

                            <!-- Features Section -->
                            <div class="features-section text-center mt-5">
                                <h3 class="features-title">Lợi ích khi đăng ký</h3>
                                <div class="row g-4">
                                    <div class="col-md-4">
                                        <div class="feature-item">
                                            <i class="bi bi-ticket-perforated text-primary"></i>
                                            <h4>Đặt vé dễ dàng</h4>
                                            <p>Quản lý và đặt vé tàu nhanh chóng</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="feature-item">
                                            <i class="bi bi-clock-history text-success"></i>
                                            <h4>Lịch sử đặt vé</h4>
                                            <p>Theo dõi tất cả chuyến đi của bạn</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="feature-item">
                                            <i class="bi bi-bell text-info"></i>
                                            <h4>Thông báo</h4>
                                            <p>Nhận thông báo về chuyến đi</p>
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
                    
                    if (password.length < 6) {
                        e.preventDefault();
                        alert('Mật khẩu phải có ít nhất 6 ký tự!');
                        return false;
                    }
                });
            }
        });
    </script>
</body>
</html> 