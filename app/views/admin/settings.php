<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cài đặt Hệ thống - Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .sidebar {
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            z-index: 1000;
            padding-top: 70px;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        
        .sidebar .nav-link {
            color: #333;
            padding: 12px 20px;
            border-radius: 0;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
        }
        
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }
        
        .content-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .settings-nav {
            background: #f8f9fa;
            border-right: 1px solid #dee2e6;
        }
        
        .settings-nav .nav-link {
            color: #333;
            border-radius: 0;
            border-left: 3px solid transparent;
        }
        
        .settings-nav .nav-link.active {
            background: white;
            border-left-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        .form-switch .form-check-input {
            width: 3rem;
            height: 1.5rem;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <button class="btn btn-link text-white d-lg-none" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>
            
            <a class="navbar-brand" href="admin.php?action=dashboard">
                <i class="bi bi-shield-lock me-2"></i>Admin Panel
            </a>
            
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1"></i>
                        <?php echo htmlspecialchars($_SESSION['admin_fullname']); ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="admin.php?action=settings">
                            <i class="bi bi-gear me-2"></i>Cài đặt
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="admin.php?action=logout">
                            <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                        </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="admin.php?action=dashboard">
                    <i class="bi bi-speedometer2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin.php?action=customers">
                    <i class="bi bi-people"></i>Khách hàng
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin.php?action=boats">
                    <i class="bi bi-ship"></i>Quản lý ghe
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin.php?action=trips">
                    <i class="bi bi-calendar-event"></i>Chuyến đi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin.php?action=bookings">
                    <i class="bi bi-ticket"></i>Đặt vé
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin.php?action=invoices">
                    <i class="bi bi-receipt"></i>Hóa đơn
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin.php?action=reports">
                    <i class="bi bi-graph-up"></i>Báo cáo
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="admin.php?action=settings">
                    <i class="bi bi-gear"></i>Cài đặt
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">Cài đặt Hệ thống</h1>
                    <p class="text-muted">Quản lý cấu hình và thông số hệ thống</p>
                </div>
            </div>

            <div class="row">
                <!-- Settings Navigation -->
                <div class="col-lg-3">
                    <div class="content-card">
                        <div class="settings-nav">
                            <div class="nav flex-column">
                                <a class="nav-link active" href="#general" data-bs-toggle="tab">
                                    <i class="bi bi-gear me-2"></i>Cài đặt chung
                                </a>
                                <a class="nav-link" href="#booking" data-bs-toggle="tab">
                                    <i class="bi bi-calendar-check me-2"></i>Quy định đặt vé
                                </a>
                                <a class="nav-link" href="#payment" data-bs-toggle="tab">
                                    <i class="bi bi-credit-card me-2"></i>Thanh toán
                                </a>
                                <a class="nav-link" href="#notification" data-bs-toggle="tab">
                                    <i class="bi bi-bell me-2"></i>Thông báo
                                </a>
                                <a class="nav-link" href="#security" data-bs-toggle="tab">
                                    <i class="bi bi-shield-lock me-2"></i>Bảo mật
                                </a>
                                <a class="nav-link" href="#backup" data-bs-toggle="tab">
                                    <i class="bi bi-cloud-arrow-up me-2"></i>Sao lưu
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Settings Content -->
                <div class="col-lg-9">
                    <div class="content-card">
                        <div class="tab-content">
                            <!-- General Settings -->
                            <div class="tab-pane fade show active" id="general">
                                <div class="card-header bg-white">
                                    <h5 class="mb-0">
                                        <i class="bi bi-gear me-2"></i>Cài đặt chung
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Tên hệ thống</label>
                                                    <input type="text" class="form-control" value="gheday - Hệ thống đặt vé tàu chợ nổi">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Địa chỉ công ty</label>
                                                    <input type="text" class="form-control" value="231-233 Lê Hồng Phong, Phường 4, Quận 5, TP. Hồ Chí Minh">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Số điện thoại</label>
                                                    <input type="text" class="form-control" value="1900 6067">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" class="form-control" value="support@gheday.vn">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Giờ hoạt động</label>
                                                    <input type="text" class="form-control" value="06:00-18:00">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Múi giờ</label>
                                                    <select class="form-select">
                                                        <option value="Asia/Ho_Chi_Minh" selected>Asia/Ho_Chi_Minh (GMT+7)</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="maintenanceMode">
                                                <label class="form-check-label" for="maintenanceMode">
                                                    Chế độ bảo trì
                                                </label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Lưu cài đặt</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Booking Settings -->
                            <div class="tab-pane fade" id="booking">
                                <div class="card-header bg-white">
                                    <h5 class="mb-0">
                                        <i class="bi bi-calendar-check me-2"></i>Quy định đặt vé
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Số giờ đặt vé trước chuyến đi</label>
                                                    <input type="number" class="form-control" value="24" min="1">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Số giờ hủy vé trước chuyến đi</label>
                                                    <input type="number" class="form-control" value="6" min="1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Số ghế mặc định cho ghe</label>
                                                    <input type="number" class="form-control" value="50" min="1">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Số vé tối đa mỗi lần đặt</label>
                                                    <input type="number" class="form-control" value="10" min="1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="allowOverbooking" checked>
                                                <label class="form-check-label" for="allowOverbooking">
                                                    Cho phép đặt quá chỗ
                                                </label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Lưu cài đặt</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Payment Settings -->
                            <div class="tab-pane fade" id="payment">
                                <div class="card-header bg-white">
                                    <h5 class="mb-0">
                                        <i class="bi bi-credit-card me-2"></i>Cài đặt thanh toán
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Thuế suất (%)</label>
                                                    <input type="number" class="form-control" value="10" min="0" max="100" step="0.1">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Phí dịch vụ (%)</label>
                                                    <input type="number" class="form-control" value="5" min="0" max="100" step="0.1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Phương thức thanh toán</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="cashPayment" checked>
                                                <label class="form-check-label" for="cashPayment">
                                                    Tiền mặt
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="bankTransfer" checked>
                                                <label class="form-check-label" for="bankTransfer">
                                                    Chuyển khoản ngân hàng
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="creditCard">
                                                <label class="form-check-label" for="creditCard">
                                                    Thẻ tín dụng
                                                </label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Lưu cài đặt</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Notification Settings -->
                            <div class="tab-pane fade" id="notification">
                                <div class="card-header bg-white">
                                    <h5 class="mb-0">
                                        <i class="bi bi-bell me-2"></i>Cài đặt thông báo
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="mb-3">
                                            <label class="form-label">Thông báo email</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="emailBooking" checked>
                                                <label class="form-check-label" for="emailBooking">
                                                    Xác nhận đặt vé
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="emailReminder" checked>
                                                <label class="form-check-label" for="emailReminder">
                                                    Nhắc nhở chuyến đi
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="emailCancellation" checked>
                                                <label class="form-check-label" for="emailCancellation">
                                                    Hủy vé
                                                </label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Thông báo SMS</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="smsBooking">
                                                <label class="form-check-label" for="smsBooking">
                                                    Xác nhận đặt vé
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="smsReminder">
                                                <label class="form-check-label" for="smsReminder">
                                                    Nhắc nhở chuyến đi
                                                </label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Lưu cài đặt</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Security Settings -->
                            <div class="tab-pane fade" id="security">
                                <div class="card-header bg-white">
                                    <h5 class="mb-0">
                                        <i class="bi bi-shield-lock me-2"></i>Cài đặt bảo mật
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Độ dài mật khẩu tối thiểu</label>
                                                    <input type="number" class="form-control" value="8" min="6" max="20">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Thời gian session (phút)</label>
                                                    <input type="number" class="form-control" value="120" min="30" max="480">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="twoFactorAuth">
                                                <label class="form-check-label" for="twoFactorAuth">
                                                    Xác thực 2 yếu tố
                                                </label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="loginAttempts" checked>
                                                <label class="form-check-label" for="loginAttempts">
                                                    Giới hạn số lần đăng nhập
                                                </label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Lưu cài đặt</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Backup Settings -->
                            <div class="tab-pane fade" id="backup">
                                <div class="card-header bg-white">
                                    <h5 class="mb-0">
                                        <i class="bi bi-cloud-arrow-up me-2"></i>Sao lưu dữ liệu
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Tần suất sao lưu tự động</label>
                                                <select class="form-select">
                                                    <option value="daily">Hàng ngày</option>
                                                    <option value="weekly" selected>Hàng tuần</option>
                                                    <option value="monthly">Hàng tháng</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Giữ sao lưu trong (ngày)</label>
                                                <input type="number" class="form-control" value="30" min="7" max="365">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="autoBackup" checked>
                                            <label class="form-check-label" for="autoBackup">
                                                Sao lưu tự động
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-success me-2" onclick="createBackup()">
                                            <i class="bi bi-cloud-arrow-up me-2"></i>Tạo sao lưu ngay
                                        </button>
                                        <button type="button" class="btn btn-info" onclick="restoreBackup()">
                                            <i class="bi bi-cloud-arrow-down me-2"></i>Khôi phục sao lưu
                                        </button>
                                    </div>
                                    <div class="alert alert-info">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Sao lưu cuối cùng: 14/01/2025 02:00
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Toggle sidebar on mobile
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }

        // Create backup
        function createBackup() {
            if (confirm('Bạn có chắc chắn muốn tạo sao lưu ngay bây giờ?')) {
                window.location.href = 'admin.php?action=create_backup';
            }
        }

        // Restore backup
        function restoreBackup() {
            if (confirm('Bạn có chắc chắn muốn khôi phục từ sao lưu? Dữ liệu hiện tại sẽ bị ghi đè.')) {
                window.location.href = 'admin.php?action=restore_backup';
            }
        }

        // Handle form submissions
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                // Form sẽ submit bình thường
            });
        });
    </script>
</body>
</html> 