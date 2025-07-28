<?php
// Xác định trang hiện tại
$current_page = '';
if (isset($_GET['controller']) && isset($_GET['action'])) {
    $current_page = $_GET['controller'] . '_' . $_GET['action'];
} elseif (isset($_GET['action'])) {
    $current_page = $_GET['action'];
} else {
    $current_page = 'customer_home';
}
?>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="img/logo_gheday.png" alt="gheday-logo">
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'customer_home') ? 'active' : ''; ?>" href="index.php?controller=customer&action=home">
                        <i class="bi bi-house me-1"></i>TRANG CHỦ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'customer_booking') ? 'active' : ''; ?>" href="index.php?controller=customer&action=booking">
                        <i class="bi bi-ticket me-1"></i>ĐẶT VÉ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'customer_booking_history') ? 'active' : ''; ?>" href="index.php?controller=customer&action=booking_history">
                        <i class="bi bi-clock-history me-1"></i>VÉ CỦA TÔI
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'customer_profile') ? 'active' : ''; ?>" href="index.php?controller=customer&action=profile">
                        <i class="bi bi-person me-1"></i>TÀI KHOẢN
                    </a>
                </li>
            </ul>
            
            <div class="navbar-nav">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="navbar-text me-3">
                        <i class="bi bi-person-circle me-1"></i>
                        Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </span>
                    <a class="btn btn-auth" href="index.php?controller=auth&action=logout">
                        <i class="bi bi-box-arrow-right me-1"></i>Đăng xuất
                    </a>
                <?php else: ?>
                    <a class="btn btn-auth me-2" href="index.php?controller=auth&action=login">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Đăng nhập
                    </a>
                    <a class="btn btn-auth btn-outline" href="index.php?controller=auth&action=register">
                        <i class="bi bi-person-plus me-1"></i>Đăng ký
                    </a>
                <?php endif; ?>
                
                <!-- Admin Link -->
                <div class="navbar-nav ms-3">
                    <a class="btn btn-auth btn-outline-secondary" href="admin.php" target="_blank">
                        <i class="bi bi-shield-lock me-1"></i>Admin
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Hero Header -->
<section class="hero-header">
    <div class="container">
        <h1>ĐẶT TẠI GHEDAY CÓ NGAY VÉ RẺ</h1>
        <p>Hành trình quảng bá hình ảnh quê tôi Miền Sông Nước.</p>
    </div>
</section>
