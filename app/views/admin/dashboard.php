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
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
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
        
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
        }
        
        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }
        
        .stats-customers { background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); }
        .stats-bookings { background: linear-gradient(135deg, var(--success-color) 0%, #20c997 100%); }
        .stats-revenue { background: linear-gradient(135deg, var(--warning-color) 0%, #fd7e14 100%); }
        .stats-pending { background: linear-gradient(135deg, var(--info-color) 0%, #6f42c1 100%); }
        
        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }
        
        .recent-activity {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .activity-item {
            padding: 1rem 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
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
                <a class="nav-link active" href="admin.php?action=dashboard">
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
                <a class="nav-link" href="admin.php?action=settings">
                    <i class="bi bi-gear"></i>Cài đặt
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <h1><i class="bi bi-speedometer2 me-2"></i>Dashboard</h1>
                <p>Thống kê tổng quan hệ thống đặt vé tàu chợ nổi</p>
            </div>

            <!-- Statistics Cards -->
            <div class="row g-4 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card bg-primary text-white">
                        <div class="stat-card-body">
                            <div class="stat-card-icon">
                                <i class="bi bi-ticket-perforated"></i>
                            </div>
                            <div class="stat-card-content">
                                <h3 class="stat-card-number"><?php echo $totalBookings ?? 0; ?></h3>
                                <p class="stat-card-label">Tổng số vé đã đặt</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card bg-success text-white">
                        <div class="stat-card-body">
                            <div class="stat-card-icon">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="stat-card-content">
                                <h3 class="stat-card-number"><?php echo $totalUsers ?? 0; ?></h3>
                                <p class="stat-card-label">Tổng số khách hàng</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card bg-warning text-white">
                        <div class="stat-card-body">
                            <div class="stat-card-icon">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div class="stat-card-content">
                                <h3 class="stat-card-number"><?php echo number_format($totalRevenue ?? 0); ?>đ</h3>
                                <p class="stat-card-label">Doanh thu tháng này</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card bg-info text-white">
                        <div class="stat-card-body">
                            <div class="stat-card-icon">
                                <i class="bi bi-clock"></i>
                            </div>
                            <div class="stat-card-content">
                                <h3 class="stat-card-number"><?php echo $pendingBookings ?? 0; ?></h3>
                                <p class="stat-card-label">Vé chờ xác nhận</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="row g-4 mb-4">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-graph-up me-2"></i>Thống kê đặt vé theo ngày (7 ngày gần nhất)
                            </h5>
                        </div>
                        <div class="card-body">
                            <canvas id="bookingChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-pie-chart me-2"></i>Trạng thái vé
                            </h5>
                        </div>
                        <div class="card-body">
                            <canvas id="statusChart" width="200" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-clock-history me-2"></i>Đặt vé gần đây
                            </h5>
                            <a href="index.php?controller=admin&action=bookings" class="btn btn-primary btn-sm">
                                Xem tất cả
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Mã vé</th>
                                            <th>Khách hàng</th>
                                            <th>Tuyến đường</th>
                                            <th>Ngày đi</th>
                                            <th>Số lượng</th>
                                            <th>Tổng tiền</th>
                                            <th>Trạng thái</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($recentBookings)): ?>
                                            <?php foreach ($recentBookings as $booking): ?>
                                                <tr>
                                                    <td>#<?php echo $booking['id']; ?></td>
                                                    <td><?php echo htmlspecialchars($booking['username']); ?></td>
                                                    <td><?php echo htmlspecialchars($booking['route']); ?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($booking['date'])); ?></td>
                                                    <td><?php echo $booking['quantity']; ?></td>
                                                    <td><?php echo number_format($booking['total_price']); ?>đ</td>
                                                    <td>
                                                        <?php
                                                        $statusClass = '';
                                                        $statusText = '';
                                                        switch($booking['status']) {
                                                            case 'pending':
                                                                $statusClass = 'warning';
                                                                $statusText = 'Chờ xác nhận';
                                                                break;
                                                            case 'confirmed':
                                                                $statusClass = 'primary';
                                                                $statusText = 'Đã xác nhận';
                                                                break;
                                                            case 'completed':
                                                                $statusClass = 'success';
                                                                $statusText = 'Đã hoàn thành';
                                                                break;
                                                            case 'cancelled':
                                                                $statusClass = 'danger';
                                                                $statusText = 'Đã hủy';
                                                                break;
                                                        }
                                                        ?>
                                                        <span class="badge bg-<?php echo $statusClass; ?>">
                                                            <?php echo $statusText; ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="index.php?controller=admin&action=view_booking&id=<?php echo $booking['id']; ?>" 
                                                           class="btn btn-sm btn-outline-primary">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8" class="text-center text-muted">
                                                    <i class="bi bi-inbox display-6"></i>
                                                    <p class="mt-2">Chưa có đặt vé nào</p>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Sample data for charts (replace with real data from PHP)
    const bookingData = {
        labels: ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'],
        datasets: [{
            label: 'Số vé đặt',
            data: [12, 19, 15, 25, 22, 30, 28],
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1
        }]
    };

    const statusData = {
        labels: ['Chờ xác nhận', 'Đã xác nhận', 'Đã hoàn thành', 'Đã hủy'],
        datasets: [{
            data: [5, 15, 25, 3],
            backgroundColor: [
                'rgba(255, 205, 86, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(255, 99, 132, 0.8)'
            ]
        }]
    };

    // Booking chart
    const bookingCtx = document.getElementById('bookingChart').getContext('2d');
    new Chart(bookingCtx, {
        type: 'line',
        data: bookingData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Status chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: statusData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
    </script>
</body>
</html> 