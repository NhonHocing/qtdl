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
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Vé Tàu Chợ Nổi - gheday</title>
    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icon Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- CSS tùy chỉnh -->
    <link rel="stylesheet" href="css/booking.css">
    <link rel="icon" href="img/logo_gheday.png" type="image/png">
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
                        <a class="nav-link" href="index.php">
                            <i class="bi bi-house me-1"></i>TRANG CHỦ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?controller=customer&action=booking">
                            <i class="bi bi-ticket me-1"></i>ĐẶT VÉ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=customer&action=booking_history">
                            <i class="bi bi-clock-history me-1"></i>VÉ CỦA TÔI
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=customer&action=profile">
                            <i class="bi bi-person me-1"></i>TÀI KHOẢN
                        </a>
                    </li>
                </ul>
                
                <div class="navbar-nav">
                    <span class="navbar-text me-3">
                        <i class="bi bi-person-circle me-1"></i>
                        Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </span>
                    <a class="btn btn-auth" href="index.php?action=logout">
                        <i class="bi bi-box-arrow-right me-1"></i>Đăng xuất
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Nội dung chính -->
    <main style="margin-top: 76px;">
        <!-- Hero đặt vé -->
        <section class="booking-hero">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h1 class="booking-title">Đặt Vé Tàu Chợ Nổi Cần Thơ</h1>
                        <p class="booking-subtitle">Khám phá văn hóa sông nước miền Tây với những chuyến tàu thú vị</p>
                        <div class="booking-features">
                            <div class="feature-item">
                                <i class="bi bi-clock-history text-primary"></i>
                                <span>Đặt vé nhanh chóng</span>
                            </div>
                            <div class="feature-item">
                                <i class="bi bi-shield-check text-success"></i>
                                <span>Thanh toán an toàn</span>
                            </div>
                            <div class="feature-item">
                                <i class="bi bi-headset text-info"></i>
                                <span>Hỗ trợ 24/7</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Form đặt vé -->
        <section class="booking-form-section py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">

                        <div class="card shadow">
                            <div class="card-header bg-primary text-white">
                                <h3 class="card-title mb-0">
                                    <i class="bi bi-ticket-perforated me-2"></i>Đặt Vé Tàu
                                </h3>
                            </div>
                            <div class="card-body">
                                <form id="bookingForm" method="POST" action="index.php?controller=booking&action=book_ticket">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="route" class="form-label">
                                                <i class="bi bi-route me-1"></i>Tuyến đường <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select" id="route" name="route" required onchange="tinhGiaVe()">
                                                <option value="">Chọn tuyến đường</option>
                                                <option value="ninh_kieu_cai_rang" data-price="150000" data-duration="90">Bến Ninh Kiều → Chợ nổi Cái Răng (1h30p)</option>
                                                <option value="an_binh_cai_rang" data-price="100000" data-duration="60">Chợ An Bình → Chợ nổi Cái Răng (1h)</option>
                                                <option value="ninh_kieu_cu_lao_may" data-price="300000" data-duration="240">Bến Ninh Kiều → Cù Lao Mây (4h)</option>
                                                <option value="cai_rang_phong_dien" data-price="200000" data-duration="120">Chợ nổi Cái Răng → Phong Điền (2h)</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="date" class="form-label">
                                                <i class="bi bi-calendar-event me-1"></i>Ngày đi <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" class="form-control" id="date" name="date" required 
                                                   min="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="quantity" class="form-label">
                                                <i class="bi bi-people me-1"></i>Số lượng vé <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" class="form-control" id="quantity" name="quantity" 
                                                   min="1" max="10" value="1" required onchange="tinhGiaVe()">
                                            <div class="form-text">Tối đa 10 vé mỗi lần đặt</div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="time" class="form-label">
                                                <i class="bi bi-clock me-1"></i>Giờ khởi hành <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select" id="time" name="time" required>
                                                <option value="">Chọn giờ</option>
                                                <option value="06:00">06:00 - Sáng sớm</option>
                                                <option value="08:00">08:00 - Buổi sáng</option>
                                                <option value="10:00">10:00 - Giữa sáng</option>
                                                <option value="14:00">14:00 - Buổi chiều</option>
                                                <option value="16:00">16:00 - Chiều muộn</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Hiển thị tính giá -->
                                    <div class="price-calculation mb-4">
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <i class="bi bi-calculator me-2"></i>Chi tiết giá vé
                                                </h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p><strong>Giá vé/người:</strong> <span id="pricePerTicket">0</span> VNĐ</p>
                                                        <p><strong>Thời gian hành trình:</strong> <span id="duration">0</span> phút</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p><strong>Số lượng vé:</strong> <span id="ticketQuantity">1</span></p>
                                                        <p><strong>Tổng tiền:</strong> <span id="totalPrice" class="text-primary fw-bold fs-5">0</span> VNĐ</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="phone" class="form-label">
                                                <i class="bi bi-telephone me-1"></i>Số điện thoại <span class="text-danger">*</span>
                                            </label>
                                            <input type="tel" class="form-control" id="phone" name="phone" 
                                                   pattern="[0-9]{10,11}" required>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">
                                                <i class="bi bi-envelope me-1"></i>Email <span class="text-danger">*</span>
                                            </label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="notes" class="form-label">
                                            <i class="bi bi-chat-text me-1"></i>Ghi chú
                                        </label>
                                        <textarea class="form-control" id="notes" name="notes" rows="3" 
                                                  placeholder="Yêu cầu đặc biệt hoặc ghi chú..."></textarea>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="bi bi-check-circle me-2"></i>Xác nhận đặt vé
                                        </button>
                                        <a href="index.php?controller=customer&action=home" class="btn btn-outline-secondary">
                                            <i class="bi bi-arrow-left me-2"></i>Quay lại trang chủ
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Thông tin tuyến đường -->
        <section class="route-info-section py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="text-center mb-5">
                            <h2 class="section-title">THÔNG TIN TUYẾN ĐƯỜNG</h2>
                            <p class="text-muted">Khám phá các tuyến đường thú vị tại Cần Thơ</p>
                        </div>
                        
                        <div class="row g-4">
                            <!-- Tuyến 1 -->
                            <div class="col-md-6 col-lg-4">
                                <div class="route-info-card card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center p-4">
                                        <div class="route-icon mb-3">
                                            <i class="bi bi-geo-alt text-primary" style="font-size: 3rem;"></i>
                                        </div>
                                        <h5 class="card-title text-primary mb-3">Bến Ninh Kiều → Chợ nổi Cái Răng</h5>
                                        <p class="card-text text-muted mb-3">
                                            Tuyến đường phổ biến nhất, khám phá chợ nổi Cái Răng nổi tiếng
                                        </p>
                                        <div class="route-details">
                                            <span class="badge bg-success me-2">Thời gian: 45 phút</span>
                                            <span class="badge bg-warning text-dark">Giá: 150.000đ</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tuyến 2 -->
                            <div class="col-md-6 col-lg-4">
                                <div class="route-info-card card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center p-4">
                                        <div class="route-icon mb-3">
                                            <i class="bi bi-water text-info" style="font-size: 3rem;"></i>
                                        </div>
                                        <h5 class="card-title text-info mb-3">Chợ An Bình → Chợ nổi Cái Răng</h5>
                                        <p class="card-text text-muted mb-3">
                                            Trải nghiệm chợ nổi từ góc nhìn khác, thú vị và độc đáo
                                        </p>
                                        <div class="route-details">
                                            <span class="badge bg-success me-2">Thời gian: 30 phút</span>
                                            <span class="badge bg-warning text-dark">Giá: 120.000đ</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tuyến 3 -->
                            <div class="col-md-6 col-lg-4">
                                <div class="route-info-card card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center p-4">
                                        <div class="route-icon mb-3">
                                            <i class="bi bi-tree text-success" style="font-size: 3rem;"></i>
                                        </div>
                                        <h5 class="card-title text-success mb-3">Bến Ninh Kiều → Cù Lao Mây</h5>
                                        <p class="card-text text-muted mb-3">
                                            Khám phá cù lao xanh mướt, trải nghiệm thiên nhiên hoang dã
                                        </p>
                                        <div class="route-details">
                                            <span class="badge bg-success me-2">Thời gian: 90 phút</span>
                                            <span class="badge bg-warning text-dark">Giá: 250.000đ</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tuyến 4 -->
                            <div class="col-md-6 col-lg-4">
                                <div class="route-info-card card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center p-4">
                                        <div class="route-icon mb-3">
                                            <i class="bi bi-flower1 text-warning" style="font-size: 3rem;"></i>
                                        </div>
                                        <h5 class="card-title text-warning mb-3">Chợ nổi Cái Răng → Phong Điền</h5>
                                        <p class="card-text text-muted mb-3">
                                            Hành trình khám phá vùng đất trái cây nổi tiếng miền Tây
                                        </p>
                                        <div class="route-details">
                                            <span class="badge bg-success me-2">Thời gian: 60 phút</span>
                                            <span class="badge bg-warning text-dark">Giá: 180.000đ</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tuyến 5 -->
                            <div class="col-md-6 col-lg-4">
                                <div class="route-info-card card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center p-4">
                                        <div class="route-icon mb-3">
                                            <i class="bi bi-sunrise text-danger" style="font-size: 3rem;"></i>
                                        </div>
                                        <h5 class="card-title text-danger mb-3">Chuyến Sáng Sớm</h5>
                                        <p class="card-text text-muted mb-3">
                                            Trải nghiệm chợ nổi vào buổi sáng sớm, không khí trong lành
                                        </p>
                                        <div class="route-details">
                                            <span class="badge bg-info me-2">Giờ khởi hành: 06:00</span>
                                            <span class="badge bg-warning text-dark">Giảm: 10%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tuyến 6 -->
                            <div class="col-md-6 col-lg-4">
                                <div class="route-info-card card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center p-4">
                                        <div class="route-icon mb-3">
                                            <i class="bi bi-moon-stars text-primary" style="font-size: 3rem;"></i>
                                        </div>
                                        <h5 class="card-title text-primary mb-3">Chuyến Hoàng Hôn</h5>
                                        <p class="card-text text-muted mb-3">
                                            Ngắm hoàng hôn trên sông Hậu, khung cảnh lãng mạn tuyệt đẹp
                                        </p>
                                        <div class="route-details">
                                            <span class="badge bg-info me-2">Giờ khởi hành: 16:00</span>
                                            <span class="badge bg-warning text-dark">Giảm: 15%</span>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Tính toán giá vé tự động
    function tinhGiaVe() {
        const tuyenduong = document.getElementById('route');
        const soluong = document.getElementById('quantity');
        const giaVeSpan = document.getElementById('pricePerTicket');
        const thoiGianSpan = document.getElementById('duration');
        const soLuongSpan = document.getElementById('ticketQuantity');
        const tongTienSpan = document.getElementById('totalPrice');
        
        if (tuyenduong.value) {
            const tuyenduongChon = tuyenduong.options[tuyenduong.selectedIndex];
            const giaVe = parseInt(tuyenduongChon.dataset.price);
            const thoiGian = parseInt(tuyenduongChon.dataset.duration);
            const soLuongVe = parseInt(soluong.value);
            
            const tongTien = giaVe * soLuongVe;
            
            // Cập nhật hiển thị giá vé
            giaVeSpan.textContent = giaVe.toLocaleString();
            thoiGianSpan.textContent = thoiGian;
            soLuongSpan.textContent = soLuongVe;
            tongTienSpan.textContent = tongTien.toLocaleString();
        } else {
            // Đặt lại giá trị mặc định
            giaVeSpan.textContent = '0';
            thoiGianSpan.textContent = '0';
            soLuongSpan.textContent = '1';
            tongTienSpan.textContent = '0';
        }
    }
    
    // Ngày tối thiểu là hôm nay
    document.addEventListener('DOMContentLoaded', function() {
        const homNay = new Date().toISOString().split('T')[0];
        document.getElementById('date').min = homNay;
        
        // Tự động chọn tuyến đường từ URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        const selectedRoute = urlParams.get('route');
        if (selectedRoute) {
            const routeSelect = document.getElementById('route');
            routeSelect.value = selectedRoute;
            // Tính giá vé sau khi chọn tuyến đường
            tinhGiaVe();
        }
        
        // Tính giá vé ban đầu
        tinhGiaVe();
    });
    
    // Kiểm tra form
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        const tuyenduong = document.getElementById('route').value;
        const ngayDi = document.getElementById('date').value;
        const soLuong = document.getElementById('quantity').value;
        const gioKhoiHanh = document.getElementById('time').value;
        const soDienThoai = document.getElementById('phone').value;
        const email = document.getElementById('email').value;
        
        if (!tuyenduong || !ngayDi || !soLuong || !gioKhoiHanh || !soDienThoai || !email) {
            e.preventDefault();
            alert('Vui lòng điền đầy đủ thông tin bắt buộc!');
            return false;
        }
        
        // Kiểm tra số điện thoại
        const dinhDangSDT = /^[0-9]{10,11}$/;
        if (!dinhDangSDT.test(soDienThoai)) {
            e.preventDefault();
            alert('Số điện thoại không hợp lệ!');
            return false;
        }
        
        // Kiểm tra email
        const dinhDangEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!dinhDangEmail.test(email)) {
            e.preventDefault();
            alert('Email không hợp lệ!');
            return false;
        }
        
        // Kiểm tra ngày không được trong quá khứ
        const ngayChon = new Date(ngayDi);
        const homNay = new Date();
        homNay.setHours(0, 0, 0, 0);
        
        if (ngayChon < homNay) {
            e.preventDefault();
            alert('Ngày đi không thể trong quá khứ!');
            return false;
        }
        
        // Xác nhận đặt vé
        if (!confirm('Xác nhận đặt vé với thông tin trên?')) {
            e.preventDefault();
            return false;
        }
    });
    </script>
</body>
</html>
