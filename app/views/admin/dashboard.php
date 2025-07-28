<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - gheday</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- CSS Admin -->
    <link rel="stylesheet" href="css/admin.css">
</head>
<body class="admin-body">
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

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="public/img/logo_gheday.png" alt="gheday Logo" height="50" class="mb-3">
            <h5>Quản lý hệ thống</h5>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="index.php?controller=admin&action=dashboard">
                    <i class="bi bi-speedometer2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?controller=admin&action=customers">
                    <i class="bi bi-people"></i>Khách hàng
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?controller=admin&action=boats">
                    <i class="bi bi-water"></i>Quản lý ghe
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?controller=admin&action=trips">
                    <i class="bi bi-calendar-event"></i>Chuyến đi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?controller=admin&action=bookings">
                    <i class="bi bi-ticket-perforated"></i>Đặt vé
                </a>
            </li>

            <li class="nav-item mt-4">
                <a class="nav-link" href="index.php?controller=admin&action=logout">
                    <i class="bi bi-box-arrow-right"></i>Đăng xuất
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="bi bi-speedometer2 text-primary" style="font-size: 2rem;"></i>
                        </div>
                        <div>
                            <h1 class="mb-1">Dashboard</h1>
                            <p class="mb-0 text-muted">Thống kê tổng quan hệ thống đặt vé tàu chợ nổi</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row g-4 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="card-icon primary">
                                    <i class="bi bi-ticket-perforated"></i>
                                </div>
                            </div>
                            <div>
                                <div class="card-title">Tổng đặt vé</div>
                                <div class="card-value"><?php echo number_format($totalBookings); ?></div>
                                <div class="card-change"><?php echo $pendingBookings; ?> đang chờ xác nhận</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="card-icon success">
                                    <i class="bi bi-people"></i>
                                </div>
                            </div>
                            <div>
                                <div class="card-title">Khách hàng</div>
                                <div class="card-value"><?php echo number_format($totalUsers); ?></div>
                                <div class="card-change">Tổng số khách hàng đã đăng ký</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="card-icon warning">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                            </div>
                            <div>
                                <div class="card-title">Doanh thu tháng</div>
                                <div class="card-value"><?php echo number_format($totalRevenue); ?> VNĐ</div>
                                <div class="card-change">Doanh thu tháng hiện tại</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="card-icon danger">
                                    <i class="bi bi-clock"></i>
                                </div>
                            </div>
                            <div>
                                <div class="card-title">Chờ xử lý</div>
                                <div class="card-value"><?php echo $pendingBookings; ?></div>
                                <div class="card-change">Đặt vé chờ xác nhận</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Đặt vé gần đây</h5>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($recentBookings)): ?>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Khách hàng</th>
                                                <th>Tuyến đường</th>
                                                <th>Ngày đi</th>
                                                <th>Tổng tiền</th>
                                                <th>Trạng thái</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recentBookings as $booking): ?>
                                                <tr>
                                                    <td>#<?php echo $booking['id']; ?></td>
                                                    <td><?php echo htmlspecialchars($booking['passenger_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($booking['route']); ?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($booking['departure_date'])); ?></td>
                                                    <td><?php echo number_format($booking['total_price']); ?> VNĐ</td>
                                                    <td>
                                                        <?php
                                                        $statusClass = '';
                                                        $statusText = '';
                                                        switch ($booking['status']) {
                                                            case 'pending':
                                                                $statusClass = 'bg-warning';
                                                                $statusText = 'Chờ xác nhận';
                                                                break;
                                                            case 'confirmed':
                                                                $statusClass = 'bg-success';
                                                                $statusText = 'Đã xác nhận';
                                                                break;
                                                            case 'completed':
                                                                $statusClass = 'bg-primary';
                                                                $statusText = 'Hoàn thành';
                                                                break;
                                                            case 'cancelled':
                                                                $statusClass = 'bg-danger';
                                                                $statusText = 'Đã hủy';
                                                                break;
                                                            default:
                                                                $statusClass = 'bg-secondary';
                                                                $statusText = 'Không xác định';
                                                        }
                                                        ?>
                                                        <span class="badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                                    </td>
                                                    <td>
                                                        <a href="index.php?controller=admin&action=booking_detail&id=<?php echo $booking['id']; ?>" class="btn btn-sm btn-primary">
                                                            <i class="bi bi-eye"></i> Xem
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">Chưa có đặt vé nào.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }
    </script>
</body>
</html> 