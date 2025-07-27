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
require_once __DIR__ . '/../models/BookingModel.php';
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
        <!-- Tìm kiếm và lọc -->
        <section class="search-filter-section py-4 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <label for="searchDate" class="form-label">Tìm theo ngày:</label>
                        <input type="date" class="form-control" id="searchDate" name="searchDate">
                    </div>
                    <div class="col-md-4">
                        <label for="filterStatus" class="form-label">Lọc theo trạng thái:</label>
                        <select class="form-select" id="filterStatus" name="filterStatus">
                            <option value="">Tất cả</option>
                            <option value="pending">Chờ xác nhận</option>
                            <option value="confirmed">Đã xác nhận</option>
                            <option value="completed">Đã hoàn thành</option>
                            <option value="cancelled">Đã hủy</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="button" class="btn btn-primary me-2" onclick="timKiemVe()">
                            <i class="bi bi-search me-1"></i>Tìm kiếm
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="lamMoiTimKiem()">
                            <i class="bi bi-arrow-clockwise me-1"></i>Làm mới
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Lịch sử đặt vé -->
        <section class="booking-history-section py-5">
            <div class="container">
                <h2 class="section-title text-center mb-5">
                    <i class="bi bi-clock-history me-2"></i>LỊCH SỬ ĐẶT VÉ
                </h2>

                <?php if (!empty($thongBaoThanhCong)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i><?php echo $thongBaoThanhCong; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (!empty($thongBaoLoi)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i><?php echo $thongBaoLoi; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (empty($danhSachVe)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <h3 class="mt-3">Chưa có vé nào</h3>
                        <p class="text-muted">Bạn chưa đặt vé nào. Hãy đặt vé đầu tiên của bạn!</p>
                        <a href="index.php?controller=customer&action=booking" class="btn btn-primary">
                            <i class="bi bi-ticket-perforated me-1"></i>Đặt Vé Ngay
                        </a>
                    </div>
                <?php else: ?>
                    <div class="row" id="bookingsContainer">
                        <?php foreach ($danhSachVe as $ve): ?>
                            <?php $thongTinTrangThai = layThongTinTrangThai($ve['status']); ?>
                            <div class="col-lg-6 col-md-12 mb-4 booking-card" 
                                 data-date="<?php echo $ve['date']; ?>"
                                 data-status="<?php echo $ve['status']; ?>">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">
                                            <i class="bi bi-ticket-perforated me-2"></i>
                                            Vé #<?php echo $ve['id']; ?>
                                        </h5>
                                        <span class="badge bg-<?php echo $thongTinTrangThai['class']; ?>">
                                            <i class="bi <?php echo $thongTinTrangThai['icon']; ?> me-1"></i>
                                            <?php echo $thongTinTrangThai['text']; ?>
                                        </span>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Tuyến đường:</strong><br>
                                                    <?php echo dinhDangTenTuyenDuong($ve['route']); ?>
                                                </p>
                                                <p><strong>Ngày đi:</strong><br>
                                                    <?php echo date('d/m/Y', strtotime($ve['date'])); ?>
                                                </p>
                                                <p><strong>Số lượng vé:</strong><br>
                                                    <?php echo $ve['quantity']; ?> vé
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Tổng tiền:</strong><br>
                                                    <span class="text-primary fw-bold">
                                                        <?php echo number_format($ve['total_price']); ?> VNĐ
                                                    </span>
                                                </p>
                                                <p><strong>Ngày đặt:</strong><br>
                                                    <?php echo date('d/m/Y H:i', strtotime($ve['created_at'])); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <?php if ($ve['status'] === 'pending' || $ve['status'] === 'confirmed'): ?>
                                            <button class="btn btn-danger btn-sm" 
                                                    onclick="huyVe(<?php echo $ve['id']; ?>)">
                                                <i class="bi bi-x-circle me-1"></i>Hủy Vé
                                            </button>
                                        <?php endif; ?>
                                        <button class="btn btn-info btn-sm ms-2" 
                                                onclick="xemChiTietVe(<?php echo $ve['id']; ?>)">
                                            <i class="bi bi-eye me-1"></i>Chi tiết
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <!-- Chân trang -->
    <?php include __DIR__ . '/../layouts/footer.php'; ?>

    <!-- JS Bootstrap -->
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
            window.location.href = `index.php?controller=booking&action=cancel&id=${maVe}`;
        }
    }
    
    function xemChiTietVe(maVe) {
        window.location.href = `index.php?controller=booking&action=detail&id=${maVe}`;
    }
    </script>
</body>
</html>
