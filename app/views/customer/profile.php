<?php
// Bắt đầu session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?action=login");
    exit();
}

// Thông báo
$thongBaoThanhCong = '';
$thongBaoLoi = '';

if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case 'profile':
            $thongBaoThanhCong = 'Cập nhật thông tin cá nhân thành công!';
            break;
        case 'password':
            $thongBaoThanhCong = 'Thay đổi mật khẩu thành công!';
            break;
        default:
            $thongBaoThanhCong = 'Thao tác thành công!';
    }
}

if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'current_password':
            $thongBaoLoi = 'Mật khẩu hiện tại không đúng.';
            break;
        case 'password_mismatch':
            $thongBaoLoi = 'Mật khẩu mới và xác nhận mật khẩu không khớp.';
            break;
        case 'email_exists':
            $thongBaoLoi = 'Email này đã được sử dụng bởi tài khoản khác.';
            break;
        case 'phone_exists':
            $thongBaoLoi = 'Số điện thoại này đã được sử dụng bởi tài khoản khác.';
            break;
        default:
            $thongBaoLoi = 'Có lỗi xảy ra. Vui lòng thử lại.';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ Sơ Cá Nhân - gheday</title>
    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icon Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- CSS tùy chỉnh -->
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
    <!-- Thanh điều hướng -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="img/logo_gheday.png" alt="gheday Logo" height="50">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=customer&action=home">
                            <i class="bi bi-house me-1"></i>TRANG CHỦ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=customer&action=booking">
                            <i class="bi bi-ticket me-1"></i>ĐẶT VÉ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=customer&action=booking_history">
                            <i class="bi bi-clock-history me-1"></i>VÉ CỦA TÔI
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?controller=customer&action=profile">
                            <i class="bi bi-person me-1"></i>TÀI KHOẢN
                        </a>
                    </li>
                </ul>
                
                <div class="navbar-nav">
                    <span class="navbar-text me-3">
                        <i class="bi bi-person-circle me-1"></i>
                        Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </span>
                    <a class="btn btn-auth" href="index.php?controller=auth&action=logout">
                        <i class="bi bi-box-arrow-right me-1"></i>Đăng xuất
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Nội dung chính -->
    <main style="margin-top: 76px;">
        <!-- Tiêu đề trang -->
        <section class="page-header">
            <div class="container">
                <h1 class="page-title">
                    <i class="bi bi-person-circle me-3"></i>Hồ Sơ Cá Nhân
                </h1>
                <p class="page-subtitle">Quản lý thông tin tài khoản và cài đặt cá nhân</p>
            </div>
        </section>

        <!-- Profile Content -->
        <section class="profile-section">
            <div class="container">
                <!-- Thông báo thành công/lỗi -->
                <?php if ($success_message): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i><?php echo htmlspecialchars($success_message); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if ($error_message): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i><?php echo htmlspecialchars($error_message); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <!-- Thanh bên hồ sơ -->
                    <div class="col-lg-3">
                        <div class="profile-sidebar">
                            <div class="profile-avatar">
                                <div class="avatar-container">
                                    <i class="bi bi-person-circle"></i>
                                </div>
                                <h3 class="user-name"><?php echo htmlspecialchars($_SESSION['fullname'] ?? $_SESSION['username']); ?></h3>
                                <p class="user-email"><?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?></p>
                                <p class="user-phone"><?php echo htmlspecialchars($_SESSION['phone'] ?? ''); ?></p>
                            </div>
                            
                            <nav class="profile-nav">
                                <a href="#profile-info" class="nav-link active" data-bs-toggle="tab">
                                    <i class="bi bi-person me-2"></i>Thông Tin Cá Nhân
                                </a>
                                <a href="#security" class="nav-link" data-bs-toggle="tab">
                                    <i class="bi bi-shield-lock me-2"></i>Bảo Mật
                                </a>
                                <a href="#preferences" class="nav-link" data-bs-toggle="tab">
                                    <i class="bi bi-gear me-2"></i>Cài Đặt
                                </a>
                                <a href="#notifications" class="nav-link" data-bs-toggle="tab">
                                    <i class="bi bi-bell me-2"></i>Thông Báo
                                </a>
                            </nav>
                        </div>
                    </div>

                    <!-- Nội dung hồ sơ -->
                    <div class="col-lg-9">
                        <div class="profile-content">
                            <div class="tab-content">
                                <!-- Tab thông tin hồ sơ -->
                                <div class="tab-pane fade show active" id="profile-info">
                                    <div class="content-card">
                                        <div class="card-header">
                                            <h2><i class="bi bi-person me-2"></i>Thông Tin Cá Nhân</h2>
                                            <p>Cập nhật thông tin cá nhân của bạn</p>
                                        </div>
                                        
                                        <form action="index.php?action=update_profile" method="POST">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label fw-bold">
                                                            <i class="bi bi-person me-2"></i>Họ Tên <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control" name="fullname" 
                                                               value="<?php echo htmlspecialchars($_SESSION['fullname'] ?? ''); ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label fw-bold">
                                                            <i class="bi bi-person-badge me-2"></i>Tên Đăng Nhập
                                                        </label>
                                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" readonly>
                                                        <small class="form-text text-muted">Tên đăng nhập không thể thay đổi</small>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label fw-bold">
                                                            <i class="bi bi-envelope me-2"></i>Email <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="email" class="form-control" name="email" 
                                                               value="<?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label fw-bold">
                                                            <i class="bi bi-telephone me-2"></i>Số Điện Thoại <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="tel" class="form-control" name="phone" 
                                                               value="<?php echo htmlspecialchars($_SESSION['phone'] ?? ''); ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="bi bi-geo-alt me-2"></i>Địa Chỉ
                                                </label>
                                                <textarea class="form-control" name="address" rows="3" placeholder="Nhập địa chỉ của bạn"><?php echo htmlspecialchars($_SESSION['address'] ?? ''); ?></textarea>
                                            </div>
                                            
                                            <div class="form-actions">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="bi bi-check-circle me-2"></i>Cập Nhật Thông Tin
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Tab bảo mật -->
                                <div class="tab-pane fade" id="security">
                                    <div class="content-card">
                                        <div class="card-header">
                                            <h2><i class="bi bi-shield-lock me-2"></i>Bảo Mật Tài Khoản</h2>
                                            <p>Thay đổi mật khẩu và cài đặt bảo mật</p>
                                        </div>
                                        
                                        <form action="index.php?action=change_password" method="POST" id="passwordForm">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="bi bi-lock me-2"></i>Mật Khẩu Hiện Tại <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" name="current_password" id="currentPassword" required>
                                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('currentPassword')">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label fw-bold">
                                                            <i class="bi bi-lock-fill me-2"></i>Mật Khẩu Mới <span class="text-danger">*</span>
                                                        </label>
                                                        <div class="input-group">
                                                            <input type="password" class="form-control" name="new_password" id="newPassword" required>
                                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('newPassword')">
                                                                <i class="bi bi-eye"></i>
                                                            </button>
                                                        </div>
                                                        <small class="form-text text-muted">Mật khẩu phải có ít nhất 6 ký tự</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label fw-bold">
                                                            <i class="bi bi-lock-fill me-2"></i>Xác Nhận Mật Khẩu Mới <span class="text-danger">*</span>
                                                        </label>
                                                        <div class="input-group">
                                                            <input type="password" class="form-control" name="confirm_password" id="confirmPassword" required>
                                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirmPassword')">
                                                                <i class="bi bi-eye"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-actions">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="bi bi-shield-check me-2"></i>Thay Đổi Mật Khẩu
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Tab cài đặt -->
                                <div class="tab-pane fade" id="preferences">
                                    <div class="content-card">
                                        <div class="card-header">
                                            <h2><i class="bi bi-gear me-2"></i>Cài Đặt Cá Nhân</h2>
                                            <p>Tùy chỉnh trải nghiệm sử dụng</p>
                                        </div>
                                        
                                        <div class="preferences-section">
                                            <h4 class="section-title">Ngôn Ngữ</h4>
                                            <div class="form-group mb-3">
                                                <select class="form-select">
                                                    <option value="vi" selected>Tiếng Việt</option>
                                                    <option value="en">English</option>
                                                </select>
                                            </div>
                                            
                                            <h4 class="section-title">Múi Giờ</h4>
                                            <div class="form-group mb-3">
                                                <select class="form-select">
                                                    <option value="Asia/Ho_Chi_Minh" selected>Việt Nam (GMT+7)</option>
                                                    <option value="UTC">UTC</option>
                                                </select>
                                            </div>
                                            
                                            <h4 class="section-title">Định Dạng Ngày</h4>
                                            <div class="form-group mb-3">
                                                <select class="form-select">
                                                    <option value="dd/mm/yyyy" selected>DD/MM/YYYY</option>
                                                    <option value="mm/dd/yyyy">MM/DD/YYYY</option>
                                                    <option value="yyyy-mm-dd">YYYY-MM-DD</option>
                                                </select>
                                            </div>
                                            
                                            <h4 class="section-title">Giao Diện</h4>
                                            <div class="form-group mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="darkMode">
                                                    <label class="form-check-label" for="darkMode">
                                                        Chế độ tối
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            <div class="form-actions">
                                                <button type="button" class="btn btn-primary" onclick="savePreferences()">
                                                    <i class="bi bi-check-circle me-2"></i>Lưu Cài Đặt
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab thông báo -->
                                <div class="tab-pane fade" id="notifications">
                                    <div class="content-card">
                                        <div class="card-header">
                                            <h2><i class="bi bi-bell me-2"></i>Cài Đặt Thông Báo</h2>
                                            <p>Quản lý thông báo và email</p>
                                        </div>
                                        
                                        <div class="notifications-section">
                                            <div class="notification-item">
                                                <div class="notification-info">
                                                    <h5>Thông báo đặt vé</h5>
                                                    <p>Nhận thông báo khi đặt vé thành công</p>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="bookingNotification" checked>
                                                </div>
                                            </div>
                                            
                                            <div class="notification-item">
                                                <div class="notification-info">
                                                    <h5>Thông báo hủy vé</h5>
                                                    <p>Nhận thông báo khi vé bị hủy</p>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="cancelNotification" checked>
                                                </div>
                                            </div>
                                            
                                            <div class="notification-item">
                                                <div class="notification-info">
                                                    <h5>Email marketing</h5>
                                                    <p>Nhận thông tin khuyến mãi và tin tức</p>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="marketingEmail">
                                                </div>
                                            </div>
                                            
                                            <div class="notification-item">
                                                <div class="notification-info">
                                                    <h5>Thông báo SMS</h5>
                                                    <p>Nhận thông báo qua tin nhắn SMS</p>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="smsNotification">
                                                </div>
                                            </div>
                                            
                                            <div class="form-actions">
                                                <button type="button" class="btn btn-primary" onclick="saveNotifications()">
                                                    <i class="bi bi-check-circle me-2"></i>Lưu Cài Đặt
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Chân trang -->
    <?php include __DIR__ . '/../layouts/footer.php'; ?>

    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Chức năng tab
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.profile-nav .nav-link');
            
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Xóa active từ tất cả link
                    navLinks.forEach(l => l.classList.remove('active'));
                    
                    // Thêm active cho link được click
                    this.classList.add('active');
                    
                    // Hiển thị tab tương ứng
                    const target = this.getAttribute('href');
                    const tabPanes = document.querySelectorAll('.tab-pane');
                    tabPanes.forEach(pane => {
                        pane.classList.remove('show', 'active');
                    });
                    
                    document.querySelector(target).classList.add('show', 'active');
                });
            });

            // Kiểm tra form mật khẩu
            const passwordForm = document.getElementById('passwordForm');
            if (passwordForm) {
                passwordForm.addEventListener('submit', function(e) {
                    const newPassword = document.getElementById('newPassword').value;
                    const confirmPassword = document.getElementById('confirmPassword').value;
                    
                    if (newPassword !== confirmPassword) {
                        e.preventDefault();
                        alert('Mật khẩu mới và xác nhận mật khẩu không khớp!');
                        return false;
                    }
                    
                    if (newPassword.length < 6) {
                        e.preventDefault();
                        alert('Mật khẩu phải có ít nhất 6 ký tự!');
                        return false;
                    }
                });
            }
        });

        // Ẩn/hiện mật khẩu
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const button = input.nextElementSibling;
            const icon = button.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }

        // Lưu cài đặt
        function savePreferences() {
            const form = document.getElementById('preferencesForm');
            if (form) {
                form.submit();
            }
        }
    </script>
</body>
</html>
