<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt vé tàu chợ nổi - gheday</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="public/css/booking.css">
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php?controller=customer&action=home">
                <img src="public/img/logo_gheday.png" alt="gheday Logo" height="40" class="me-2" onerror="this.style.display='none'">
                <span class="fw-bold">gheday</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=customer&action=home">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?controller=booking&action=book_ticket">Đặt vé</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=customer&action=booking_history">Lịch sử</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>
                                <?php echo htmlspecialchars($_SESSION['username']); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="index.php?controller=customer&action=profile">
                                    <i class="bi bi-person me-2"></i>Hồ sơ
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="index.php?controller=auth&action=logout">
                                    <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                                </a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?controller=auth&action=login">Đăng nhập</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?controller=auth&action=register">Đăng ký</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Page Header -->
                <div class="text-center mb-5">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h1 class="display-5 text-primary mb-3">
                                <i class="bi bi-ticket-perforated me-2"></i>Đặt vé tàu chợ nổi
                            </h1>
                            <p class="lead text-muted">Khám phá vẻ đẹp chợ nổi Cần Thơ với những chuyến đi thú vị</p>
                        </div>
                        <div class="col-md-6">
                            <img src="public/img/chợ ab - chợ nổi.jpg" alt="Chợ nổi" class="img-fluid rounded shadow" style="max-height: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Booking Form -->
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <h4 class="mb-0">
                            <i class="bi bi-calendar-check me-2"></i>Thông tin đặt vé
                        </h4>
                    </div>
                    <div class="card-body p-5">
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <h5><i class="bi bi-exclamation-triangle me-2"></i>Có lỗi xảy ra:</h5>
                                <ul class="mb-0">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?php echo htmlspecialchars($error); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($success)): ?>
                            <div class="alert alert-success">
                                <h5><i class="bi bi-check-circle me-2"></i>Thành công!</h5>
                                <p class="mb-0"><?php echo htmlspecialchars($success); ?></p>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="index.php?controller=booking&action=book_ticket" id="bookingForm">
                            <!-- Route Selection -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="route" class="form-label">
                                        <i class="bi bi-map me-1"></i>Tuyến đường <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" id="route" name="route" required>
                                        <option value="">Chọn tuyến đường</option>
                                        <option value="ninh_kieu_cai_rang" <?php echo (isset($_POST['route']) && $_POST['route'] == 'ninh_kieu_cai_rang') ? 'selected' : ''; ?>>
                                            Ninh Kiều → Cái Răng (150,000đ/người lớn)
                                        </option>
                                        <option value="an_binh_cai_rang" <?php echo (isset($_POST['route']) && $_POST['route'] == 'an_binh_cai_rang') ? 'selected' : ''; ?>>
                                            An Bình → Cái Răng (150,000đ/người lớn)
                                        </option>
                                        <option value="ninh_kieu_cu_lao_may" <?php echo (isset($_POST['route']) && $_POST['route'] == 'ninh_kieu_cu_lao_may') ? 'selected' : ''; ?>>
                                            Ninh Kiều → Cù Lao Mây (150,000đ/người lớn)
                                        </option>
                                        <option value="cai_rang_phong_dien" <?php echo (isset($_POST['route']) && $_POST['route'] == 'cai_rang_phong_dien') ? 'selected' : ''; ?>>
                                            Cái Răng → Phong Điền (150,000đ/người lớn)
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="departure_date" class="form-label">
                                        <i class="bi bi-calendar me-1"></i>Ngày khởi hành <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" class="form-control" id="departure_date" name="departure_date" 
                                           value="<?php echo $_POST['departure_date'] ?? ''; ?>" 
                                           min="<?php echo date('Y-m-d'); ?>" required>
                                </div>
                            </div>

                            <!-- Departure Time -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="departure_time" class="form-label">
                                        <i class="bi bi-clock me-1"></i>Giờ khởi hành <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" id="departure_time" name="departure_time" required>
                                        <option value="">Chọn giờ khởi hành</option>
                                        <option value="06:00" <?php echo (isset($_POST['departure_time']) && $_POST['departure_time'] == '06:00') ? 'selected' : ''; ?>>06:00</option>
                                        <option value="07:00" <?php echo (isset($_POST['departure_time']) && $_POST['departure_time'] == '07:00') ? 'selected' : ''; ?>>07:00</option>
                                        <option value="08:00" <?php echo (isset($_POST['departure_time']) && $_POST['departure_time'] == '08:00') ? 'selected' : ''; ?>>08:00</option>
                                        <option value="09:00" <?php echo (isset($_POST['departure_time']) && $_POST['departure_time'] == '09:00') ? 'selected' : ''; ?>>09:00</option>
                                        <option value="10:00" <?php echo (isset($_POST['departure_time']) && $_POST['departure_time'] == '10:00') ? 'selected' : ''; ?>>10:00</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Ticket Selection -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="adult_tickets" class="form-label">
                                        <i class="bi bi-person me-1"></i>Số vé người lớn (150,000đ/vé)
                                    </label>
                                    <input type="number" class="form-control" id="adult_tickets" name="adult_tickets" 
                                           value="<?php echo $_POST['adult_tickets'] ?? '0'; ?>" min="0" max="10">
                                </div>
                                <div class="col-md-6">
                                    <label for="child_tickets" class="form-label">
                                        <i class="bi bi-person-badge me-1"></i>Số vé trẻ em (75,000đ/vé)
                                    </label>
                                    <input type="number" class="form-control" id="child_tickets" name="child_tickets" 
                                           value="<?php echo $_POST['child_tickets'] ?? '0'; ?>" min="0" max="10">
                                </div>
                            </div>

                            <!-- Passenger Information -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="passenger_name" class="form-label">
                                        <i class="bi bi-person me-1"></i>Tên hành khách <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="passenger_name" name="passenger_name" 
                                           value="<?php echo htmlspecialchars($_POST['passenger_name'] ?? ''); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">
                                        <i class="bi bi-telephone me-1"></i>Số điện thoại <span class="text-danger">*</span>
                                    </label>
                                    <input type="tel" class="form-control" id="phone" name="phone" 
                                           value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>" required>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">
                                        <i class="bi bi-envelope me-1"></i>Email
                                    </label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                                </div>
                            </div>

                            <!-- Special Requests -->
                            <div class="mb-4">
                                <label for="special_requests" class="form-label">
                                    <i class="bi bi-chat-text me-1"></i>Yêu cầu đặc biệt
                                </label>
                                <textarea class="form-control" id="special_requests" name="special_requests" rows="3" 
                                          placeholder="Nhập yêu cầu đặc biệt (nếu có)..."><?php echo htmlspecialchars($_POST['special_requests'] ?? ''); ?></textarea>
                            </div>

                            <!-- Price Calculation -->
                            <div class="alert alert-info mb-4 border-0" style="background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);">
                                <h5><i class="bi bi-calculator me-2"></i>Tính toán giá vé</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2">
                                            <i class="bi bi-person me-1"></i>Vé người lớn: 
                                            <span id="adultCount" class="badge bg-primary">0</span> x 150,000đ = 
                                            <span id="adultTotal" class="fw-bold text-primary">0đ</span>
                                        </p>
                                        <p class="mb-2">
                                            <i class="bi bi-person-badge me-1"></i>Vé trẻ em: 
                                            <span id="childCount" class="badge bg-success">0</span> x 75,000đ = 
                                            <span id="childTotal" class="fw-bold text-success">0đ</span>
                                        </p>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <h5 class="mb-0">
                                            <i class="bi bi-cash-coin me-2"></i>Tổng cộng: 
                                            <span id="totalPrice" class="text-primary fw-bold fs-4">0đ</span>
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-lg px-5 py-3" 
                                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; color: white;">
                                    <i class="bi bi-check-circle me-2"></i>Xác nhận đặt vé
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Information Cards -->
                <div class="row mt-5">
                    <div class="col-md-4 mb-3">
                        <div class="card text-center h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <i class="bi bi-shield-check" style="font-size: 3rem; color: #667eea;"></i>
                                </div>
                                <h5 class="card-title">An toàn tuyệt đối</h5>
                                <p class="card-text text-muted">Tàu thuyền được kiểm tra định kỳ, đảm bảo an toàn cho hành khách.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card text-center h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <i class="bi bi-clock" style="font-size: 3rem; color: #28a745;"></i>
                                </div>
                                <h5 class="card-title">Đúng giờ</h5>
                                <p class="card-text text-muted">Chuyến đi đúng lịch trình, không làm mất thời gian của bạn.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card text-center h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <i class="bi bi-heart" style="font-size: 3rem; color: #dc3545;"></i>
                                </div>
                                <h5 class="card-title">Trải nghiệm tuyệt vời</h5>
                                <p class="card-text text-muted">Khám phá vẻ đẹp chợ nổi với những trải nghiệm độc đáo.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <p class="mb-0">&copy; 2024 gheday. Tất cả quyền được bảo lưu.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Price Calculation Script -->
    <script>
        function calculatePrice() {
            const adultTickets = parseInt(document.getElementById('adult_tickets').value) || 0;
            const childTickets = parseInt(document.getElementById('child_tickets').value) || 0;
            
            const adultPrice = adultTickets * 150000;
            const childPrice = childTickets * 75000;
            const totalPrice = adultPrice + childPrice;
            
            document.getElementById('adultCount').textContent = adultTickets;
            document.getElementById('childCount').textContent = childTickets;
            document.getElementById('adultTotal').textContent = adultPrice.toLocaleString() + 'đ';
            document.getElementById('childTotal').textContent = childPrice.toLocaleString() + 'đ';
            document.getElementById('totalPrice').textContent = totalPrice.toLocaleString() + 'đ';
        }
        
        // Calculate price when page loads
        calculatePrice();
        
        // Calculate price when ticket quantities change
        document.getElementById('adult_tickets').addEventListener('input', calculatePrice);
        document.getElementById('child_tickets').addEventListener('input', calculatePrice);
        
        // Form validation
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            const adultTickets = parseInt(document.getElementById('adult_tickets').value) || 0;
            const childTickets = parseInt(document.getElementById('child_tickets').value) || 0;
            
            if (adultTickets === 0 && childTickets === 0) {
                e.preventDefault();
                alert('Vui lòng chọn ít nhất 1 vé!');
                return false;
            }
        });
    </script>
</body>
</html> 
</html> 