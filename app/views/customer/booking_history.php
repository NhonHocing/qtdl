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

// Lấy dữ liệu vé
require_once __DIR__ . '/../../models/BookingModel.php';
$moHinhDatVe = new BookingModel();
$danhSachVe = $moHinhDatVe->getByUserId($_SESSION['user_id']);

// Thông báo
$thongBaoThanhCong = '';
$thongBaoLoi = '';

if (isset($_GET['success'])) {
    $thongBaoThanhCong = 'Hủy vé thành công!';
}

if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case '1':
            $thongBaoLoi = 'Có lỗi xảy ra khi hủy vé. Vui lòng thử lại.';
            break;
        case '2':
            $thongBaoLoi = 'Bạn không có quyền hủy vé này.';
            break;
        default:
            $thongBaoLoi = 'Có lỗi xảy ra. Vui lòng thử lại.';
    }
}

// Hiển thị trạng thái vé
function layThongTinTrangThai($trangThai) {
    switch ($trangThai) {
        case 'pending':
            return [
                'text' => 'Chờ xác nhận',
                'class' => 'warning',
                'icon' => 'bi-clock'
            ];
        case 'confirmed':
            return [
                'text' => 'Đã xác nhận',
                'class' => 'primary',
                'icon' => 'bi-check-circle'
            ];
        case 'completed':
            return [
                'text' => 'Đã hoàn thành',
                'class' => 'success',
                'icon' => 'bi-check-circle-fill'
            ];
        case 'cancelled':
            return [
                'text' => 'Đã hủy',
                'class' => 'danger',
                'icon' => 'bi-x-circle'
            ];
        default:
            return [
                'text' => 'Không xác định',
                'class' => 'secondary',
                'icon' => 'bi-question-circle'
            ];
    }
}

// Tên tuyến đường
function dinhDangTenTuyenDuong($tuyenDuong) {
    $danhSachTuyenDuong = [
        'ninh_kieu_cai_rang' => 'Bến Ninh Kiều → Chợ nổi Cái Răng',
        'an_binh_cai_rang' => 'Chợ An Bình → Chợ nổi Cái Răng',
        'ninh_kieu_cu_lao_may' => 'Bến Ninh Kiều → Cù Lao Mây',
        'cai_rang_phong_dien' => 'Chợ nổi Cái Răng → Phong Điền'
    ];
    
    return $danhSachTuyenDuong[$tuyenDuong] ?? $tuyenDuong;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch Sử Đặt Vé - gheday</title>
    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icon Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- CSS tùy chỉnh -->
    <link rel="stylesheet" href="css/booking-history.css">
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
                        <a class="nav-link active" href="index.php?controller=customer&action=booking_history">
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
                        Xin chào, <?php echo htmlspecialchars($_SESSION['fullname'] ?? $_SESSION['username'] ?? 'Khách'); ?>
                    </span>
                    <a class="btn btn-outline-danger" href="index.php?controller=auth&action=logout">
                        <i class="bi bi-box-arrow-right me-1"></i>Đăng xuất
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header Section -->
    <section class="profile-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="profile-title">
                        <i class="bi bi-clock-history me-3"></i>Lịch Sử Đặt Vé
                    </h1>
                    <p class="profile-subtitle">Xem lại các vé đã đặt và trạng thái của chúng</p>
                </div>
                <div class="col-md-4 text-end">
                    <img src="img/logo_gheday.png" alt="gheday Logo" height="80" class="profile-logo">
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="profile-content">
        <div class="container">
            <!-- Thông báo -->
            <?php if (!empty($thongBaoThanhCong)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    <?php echo htmlspecialchars($thongBaoThanhCong); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($thongBaoLoi)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <?php echo htmlspecialchars($thongBaoLoi); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Tìm kiếm và lọc -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-search me-2"></i>Tìm kiếm và lọc
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="searchDate" class="form-label">Tìm theo ngày:</label>
                            <div class="input-group">
                                <input type="date" class="form-control" id="searchDate" placeholder="mm/dd/yyyy">
                                <span class="input-group-text">
                                    <i class="bi bi-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="filterStatus" class="form-label">Lọc theo trạng thái:</label>
                            <select class="form-select" id="filterStatus">
                                <option value="">Tất cả trạng thái</option>
                                <option value="pending">Chờ xác nhận</option>
                                <option value="confirmed">Đã xác nhận</option>
                                <option value="completed">Đã hoàn thành</option>
                                <option value="cancelled">Đã hủy</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <div class="d-grid gap-2 d-md-flex">
                                <button class="btn btn-primary" onclick="timKiemVe()">
                                    <i class="bi bi-search me-1"></i>Tìm kiếm
                                </button>
                                <button class="btn btn-secondary" onclick="lamMoiTimKiem()">
                                    <i class="bi bi-arrow-clockwise me-1"></i>Làm mới
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danh sách vé -->
            <div class="row">
                <?php if (!empty($danhSachVe)): ?>
                    <?php foreach ($danhSachVe as $ve): ?>
                        <?php $trangThai = layThongTinTrangThai($ve['status']); ?>
                        <div class="col-lg-6 col-xl-4 mb-4 booking-card" 
                             data-date="<?php echo $ve['departure_date']; ?>" 
                             data-status="<?php echo $ve['status']; ?>">
                            <div class="card h-100 shadow-sm">
                                <div class="card-header bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">
                                            <i class="bi bi-ticket-perforated me-2"></i>
                                            Vé #<?php echo $ve['id']; ?>
                                        </h6>
                                        <span class="badge bg-<?php echo $trangThai['class']; ?>">
                                            <i class="bi <?php echo $trangThai['icon']; ?> me-1"></i>
                                            <?php echo $trangThai['text']; ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Tuyến đường:</strong><br>
                                                <?php echo dinhDangTenTuyenDuong($ve['route']); ?>
                                            </p>
                                            <p><strong>Ngày đi:</strong><br>
                                                <?php echo date('d/m/Y', strtotime($ve['departure_date'])); ?>
                                            </p>
                                            <p><strong>Giờ khởi hành:</strong><br>
                                                <?php echo date('H:i', strtotime($ve['departure_time'])); ?>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Số vé người lớn:</strong><br>
                                                <?php echo $ve['adult_tickets']; ?> vé
                                            </p>
                                            <p><strong>Số vé trẻ em:</strong><br>
                                                <?php echo $ve['child_tickets']; ?> vé
                                            </p>
                                            <p><strong>Tổng tiền:</strong><br>
                                                <span class="text-primary fw-bold">
                                                    <?php echo number_format($ve['total_price']); ?>đ
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-12">
                                            <p><strong>Hành khách:</strong><br>
                                                <?php echo htmlspecialchars($ve['passenger_name']); ?>
                                            </p>
                                            <p><strong>Số điện thoại:</strong><br>
                                                <?php echo htmlspecialchars($ve['phone']); ?>
                                            </p>
                                            <p><strong>Ngày đặt:</strong><br>
                                                <?php echo date('d/m/Y H:i', strtotime($ve['created_at'])); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <?php if (isset($ve['status']) && ($ve['status'] === 'pending' || $ve['status'] === 'confirmed')): ?>
                                        <button class="btn btn-danger btn-sm" 
                                                onclick="huyVe(<?php echo isset($ve['id']) ? $ve['id'] : 0; ?>)">
                                            <i class="bi bi-x-circle me-1"></i>Hủy Vé
                                        </button>
                                    <?php endif; ?>
                                    <button class="btn btn-info btn-sm ms-2" 
                                            onclick="xemChiTietVe(<?php echo isset($ve['id']) ? $ve['id'] : 0; ?>)">
                                        <i class="bi bi-eye me-1"></i>Chi tiết
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="bi bi-clock-history text-muted" style="font-size: 4rem;"></i>
                            <h4 class="text-muted mt-3">Chưa có vé nào</h4>
                            <p class="text-muted">Bạn chưa đặt vé nào. Hãy đặt vé để bắt đầu hành trình!</p>
                            <a href="index.php?controller=customer&action=booking" class="btn btn-primary">
                                <i class="bi bi-ticket-perforated me-2"></i>Đặt vé ngay
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    function timKiemVe() {
        const ngayTim = document.getElementById('searchDate').value;
        const trangThaiLoc = document.getElementById('filterStatus').value;
        const danhSachVe = document.querySelectorAll('.booking-card');
        
        danhSachVe.forEach(ve => {
            const ngayVe = ve.dataset.date;
            const trangThaiVe = ve.dataset.status;
            
            let hienThiVe = true;
            
            // Lọc theo ngày
            if (ngayTim && ngayVe !== ngayTim) {
                hienThiVe = false;
            }
            
            // Lọc theo trạng thái
            if (trangThaiLoc && trangThaiVe !== trangThaiLoc) {
                hienThiVe = false;
            }
            
            ve.style.display = hienThiVe ? 'block' : 'none';
        });
    }
    
    function lamMoiTimKiem() {
        document.getElementById('searchDate').value = '';
        document.getElementById('filterStatus').value = '';
        const danhSachVe = document.querySelectorAll('.booking-card');
        danhSachVe.forEach(ve => {
            ve.style.display = 'block';
        });
    }
    
    function huyVe(maVe) {
        if (confirm('Bạn có chắc chắn muốn hủy vé này?')) {
            // Tạo form để submit POST request
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'index.php?controller=booking&action=cancel';
            
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'booking_id';
            input.value = maVe;
            
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    function xemChiTietVe(maVe) {
        // Hiển thị thông tin chi tiết vé trong modal hoặc alert
        alert('Chi tiết vé #' + maVe + '\n\nChức năng này sẽ được phát triển thêm!');
    }
    </script>
</body>
</html>
