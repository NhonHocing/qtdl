<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo cáo Thống kê - Admin</title>
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
        
        .stats-revenue { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); }
        .stats-bookings { background: linear-gradient(135deg, #007bff 0%, #6610f2 100%); }
        .stats-customers { background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); }
        .stats-trips { background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%); }
        
        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
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
                <a class="nav-link active" href="admin.php?action=reports">
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
    <div class="main-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">Báo cáo Thống kê</h1>
                    <p class="text-muted">Tổng quan hoạt động kinh doanh</p>
                </div>
                <div>
                    <button class="btn btn-success me-2" onclick="exportReport()">
                        <i class="bi bi-download me-2"></i>Xuất báo cáo
                    </button>
                    <button class="btn btn-primary" onclick="printReport()">
                        <i class="bi bi-printer me-2"></i>In báo cáo
                    </button>
                </div>
            </div>

            <!-- Date Range Filter -->
            <div class="content-card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <label class="form-label">Từ ngày</label>
                            <input type="date" class="form-control" id="startDate" value="<?php echo date('Y-m-01'); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Đến ngày</label>
                            <input type="date" class="form-control" id="endDate" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Loại báo cáo</label>
                            <select class="form-select" id="reportType">
                                <option value="daily">Theo ngày</option>
                                <option value="weekly">Theo tuần</option>
                                <option value="monthly" selected>Theo tháng</option>
                                <option value="yearly">Theo năm</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div>
                                <button class="btn btn-primary" onclick="generateReport()">
                                    <i class="bi bi-search me-2"></i>Tạo báo cáo
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Stats -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon stats-revenue me-3">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div>
                                <h3 class="mb-0">15.250.000đ</h3>
                                <p class="text-muted mb-0">Tổng doanh thu</p>
                                <small class="text-success">
                                    <i class="bi bi-arrow-up"></i>
                                    +12.5% so với tháng trước
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon stats-bookings me-3">
                                <i class="bi bi-ticket"></i>
                            </div>
                            <div>
                                <h3 class="mb-0">125</h3>
                                <p class="text-muted mb-0">Tổng đặt vé</p>
                                <small class="text-success">
                                    <i class="bi bi-arrow-up"></i>
                                    +8.3% so với tháng trước
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon stats-customers me-3">
                                <i class="bi bi-people"></i>
                            </div>
                            <div>
                                <h3 class="mb-0">89</h3>
                                <p class="text-muted mb-0">Khách hàng mới</p>
                                <small class="text-success">
                                    <i class="bi bi-arrow-up"></i>
                                    +15.2% so với tháng trước
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon stats-trips me-3">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                            <div>
                                <h3 class="mb-0">45</h3>
                                <p class="text-muted mb-0">Chuyến đi hoàn thành</p>
                                <small class="text-success">
                                    <i class="bi bi-arrow-up"></i>
                                    +5.7% so với tháng trước
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row mb-4">
                <div class="col-lg-8">
                    <div class="chart-container">
                        <h5 class="mb-3">Doanh thu theo thời gian</h5>
                        <canvas id="revenueChart" height="100"></canvas>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="chart-container">
                        <h5 class="mb-3">Phân bố đặt vé</h5>
                        <canvas id="bookingDistributionChart" height="100"></canvas>
                    </div>
                </div>
            </div>

            <!-- Additional Charts -->
            <div class="row mb-4">
                <div class="col-lg-6">
                    <div class="chart-container">
                        <h5 class="mb-3">Top tuyến đường phổ biến</h5>
                        <canvas id="popularRoutesChart" height="100"></canvas>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="chart-container">
                        <h5 class="mb-3">Hiệu suất ghe</h5>
                        <canvas id="boatPerformanceChart" height="100"></canvas>
                    </div>
                </div>
            </div>

            <!-- Detailed Statistics Table -->
            <div class="content-card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-table me-2"></i>Thống kê chi tiết
                    </h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Tuyến đường</th>
                                <th>Số chuyến</th>
                                <th>Số vé bán</th>
                                <th>Doanh thu</th>
                                <th>Tỷ lệ lấp đầy</th>
                                <th>Đánh giá TB</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Ninh Kiều → Cái Răng</td>
                                <td>25</td>
                                <td>1,125</td>
                                <td>168.750.000đ</td>
                                <td>90%</td>
                                <td>4.5/5</td>
                            </tr>
                            <tr>
                                <td>An Bình → Cái Răng</td>
                                <td>20</td>
                                <td>800</td>
                                <td>80.000.000đ</td>
                                <td>85%</td>
                                <td>4.3/5</td>
                            </tr>
                            <tr>
                                <td>Ninh Kiều → Cù Lao Mây</td>
                                <td>15</td>
                                <td>675</td>
                                <td>202.500.000đ</td>
                                <td>75%</td>
                                <td>4.7/5</td>
                            </tr>
                            <tr>
                                <td>Cái Răng → Phong Điền</td>
                                <td>10</td>
                                <td>400</td>
                                <td>80.000.000đ</td>
                                <td>80%</td>
                                <td>4.2/5</td>
                            </tr>
                        </tbody>
                    </table>
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

        // Generate report
        function generateReport() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            const reportType = document.getElementById('reportType').value;
            
            if (!startDate || !endDate) {
                alert('Vui lòng chọn khoảng thời gian!');
                return;
            }
            
            window.location.href = `admin.php?action=generate_report&start=${startDate}&end=${endDate}&type=${reportType}`;
        }

        // Export report
        function exportReport() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            const reportType = document.getElementById('reportType').value;
            
            if (!startDate || !endDate) {
                alert('Vui lòng chọn khoảng thời gian!');
                return;
            }
            
            window.location.href = `admin.php?action=export_report&start=${startDate}&end=${endDate}&type=${reportType}`;
        }

        // Print report
        function printReport() {
            window.print();
        }

        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
                datasets: [{
                    label: 'Doanh thu (triệu VNĐ)',
                    data: [12, 19, 3, 5, 2, 3, 15, 8, 12, 18, 22, 25],
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Booking Distribution Chart
        const distributionCtx = document.getElementById('bookingDistributionChart').getContext('2d');
        new Chart(distributionCtx, {
            type: 'doughnut',
            data: {
                labels: ['Đã xác nhận', 'Chờ xác nhận', 'Hoàn tất', 'Đã hủy'],
                datasets: [{
                    data: [45, 25, 20, 10],
                    backgroundColor: [
                        '#28a745',
                        '#ffc107',
                        '#17a2b8',
                        '#dc3545'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Popular Routes Chart
        const routesCtx = document.getElementById('popularRoutesChart').getContext('2d');
        new Chart(routesCtx, {
            type: 'bar',
            data: {
                labels: ['Ninh Kiều → Cái Răng', 'An Bình → Cái Răng', 'Ninh Kiều → Cù Lao Mây', 'Cái Răng → Phong Điền'],
                datasets: [{
                    label: 'Số vé bán',
                    data: [1125, 800, 675, 400],
                    backgroundColor: [
                        '#667eea',
                        '#764ba2',
                        '#f093fb',
                        '#f5576c'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Boat Performance Chart
        const boatCtx = document.getElementById('boatPerformanceChart').getContext('2d');
        new Chart(boatCtx, {
            type: 'radar',
            data: {
                labels: ['GH001', 'GH002', 'GH003', 'GH004', 'GH005'],
                datasets: [{
                    label: 'Tỷ lệ lấp đầy (%)',
                    data: [90, 85, 75, 80, 70],
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.2)',
                    pointBackgroundColor: '#667eea'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    r: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    </script>
</body>
</html> 