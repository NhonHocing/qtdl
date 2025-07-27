<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gheday - Đặt vé tàu du lịch Miền Sông Nước</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
    <?php include __DIR__ . '/../layouts/header.php'; ?>

    <!-- Main Content -->
    <main style="margin-top: 76px;">
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="hero-content">
                    <h1 class="hero-title">Đặt vé tàu du lịch tại chợ nổi Cái Răng</h1>
                    <p class="hero-subtitle">Để có thể khám phá du lịch Miền Sông nước</p>
                    <a href="index.php?controller=customer&action=booking" class="btn btn-hero">
                        <i class="bi bi-ticket-perforated me-2"></i>Đặt Vé Ngay
                    </a>
                </div>
            </div>
        </section>

        <!-- Popular Routes Section -->
        <section class="routes-section">
            <div class="container">
                <h2 class="section-title">TUYẾN PHỔ BIẾN</h2>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="route-card">
                            <img src="img/bến - chợ.jpg" alt="Bến Ninh Kiều - Chợ nổi Cái Răng" class="card-img-top">
                            <div class="route-card-body">
                                <h3 class="route-card-title">Bến Ninh Kiều - Chợ nổi Cái Răng</h3>
                                <p class="route-card-text">
                                    <i class="bi bi-clock me-1"></i>Thời gian: 1 giờ 30 phút<br>
                                    <i class="bi bi-currency-dollar me-1"></i>Giá từ: 150.000 VNĐ
                                </p>
                                <a href="index.php?controller=customer&action=booking" class="btn btn-route">
                                    <i class="bi bi-ticket-perforated me-1"></i>Đặt Vé
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6">
                        <div class="route-card">
                            <img src="img/chợ ab - chợ nổi.jpg" alt="Chợ An Bình - Chợ nổi Cái Răng" class="card-img-top">
                            <div class="route-card-body">
                                <h3 class="route-card-title">Chợ An Bình - Chợ nổi Cái Răng</h3>
                                <p class="route-card-text">
                                    <i class="bi bi-clock me-1"></i>Thời gian: 1 giờ<br>
                                    <i class="bi bi-currency-dollar me-1"></i>Giá từ: 100.000 VNĐ
                                </p>
                                <a href="index.php?controller=customer&action=booking" class="btn btn-route">
                                    <i class="bi bi-ticket-perforated me-1"></i>Đặt Vé
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6">
                        <div class="route-card">
                            <img src="img/bến - cù lao mây.jpg" alt="Bến Ninh Kiều - Cù Lao Mây" class="card-img-top">
                            <div class="route-card-body">
                                <h3 class="route-card-title">Bến Ninh Kiều - Cù Lao Mây</h3>
                                <p class="route-card-text">
                                    <i class="bi bi-clock me-1"></i>Thời gian: 4 giờ<br>
                                    <i class="bi bi-currency-dollar me-1"></i>Giá từ: 300.000 VNĐ
                                </p>
                                <a href="index.php?controller=customer&action=booking" class="btn btn-route">
                                    <i class="bi bi-ticket-perforated me-1"></i>Đặt Vé
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- App Promo Section -->
        <section class="app-promo">
            <div class="container">
                <h2>ĐẶT VÉ GHEDAY CÓ NGAY VÉ RẺ</h2>
                <p>Đặt vé, theo dõi chuyến tàu, trên website nhanh chóng và tiện lợi</p>
            </div>
        </section>
    </main>

    <?php include __DIR__ . '/../layouts/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
