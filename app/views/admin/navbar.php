<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top admin-navbar">
    <div class="container-fluid">
        <button class="btn btn-link text-dark d-lg-none" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </button>
        
        <a class="navbar-brand" href="index.php?controller=admin&action=dashboard">
            <img src="public/img/logo_gheday.png" alt="gheday Logo" height="40" class="me-2">
            Admin Panel
        </a>
        
        <!-- Navigation Menu -->
        <div class="navbar-nav ms-auto">
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle me-1"></i>
                    <?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="index.php?controller=admin&action=profile">
                        <i class="bi bi-person me-2"></i>Hồ sơ
                    </a></li>
                    <li><a class="dropdown-item" href="index.php?controller=admin&action=settings">
                        <i class="bi bi-gear me-2"></i>Cài đặt
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="index.php?controller=auth&action=logout">
                        <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                    </a></li>
                </ul>
            </div>
        </div>
    </div>
</nav> 