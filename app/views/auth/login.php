<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập - gheday</title>
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
                        <a class="nav-link" href="index.php?controller=auth&action=register">
                            <i class="bi bi-person-plus me-1"></i>Đăng Ký
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main style="margin-top: 76px;">
        <!-- Login Container -->
        <div class="auth-container">
            <div class="container">
                <div class="row justify-content-center align-items-center min-vh-100">
                    <div class="col-lg-6 col-md-8">
                        <div class="auth-wrapper">
                            <!-- Logo Section -->
                            <div class="logo-section text-center mb-4">
                                <img src="img/logo_gheday.png" alt="gheday Logo" class="auth-logo">
                                <h1 class="auth-title">Đăng Nhập</h1>
                                <p class="auth-subtitle">Chào mừng bạn trở lại với gheday</p>
                            </div>

                            <!-- Login Form -->
                            <div class="form-container login-form">
                                <div class="form-header">
                                    <h2><i class="bi bi-box-arrow-in-right me-2"></i>Đăng Nhập Tài Khoản</h2>
                                    <p>Nhập thông tin đăng nhập của bạn</p>
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
                                        <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
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

                                <!-- Divider -->
                                <div class="divider my-4">
                                    <span>hoặc</span>
                                </div>

                                <!-- Register Link -->
                                <div class="text-center">
                                    <p class="mb-0">Chưa có tài khoản? 
                                        <a href="index.php?controller=auth&action=register" class="text-decoration-none fw-bold">Đăng ký ngay</a>
                                    </p>
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
        });
    </script>
</body>
</html> 