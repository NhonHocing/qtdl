<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Đặt vé - Admin</title>
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
            <div class="navbar-nav me-auto">
                <a class="nav-link" href="index.php?controller=admin&action=dashboard">
                    <i class="bi bi-speedometer2 me-1"></i>Dashboard
                </a>
                <a class="nav-link" href="index.php?controller=admin&action=customers">
                    <i class="bi bi-people me-1"></i>Khách hàng
                </a>
                <a class="nav-link active" href="index.php?controller=admin&action=bookings">
                    <i class="bi bi-ticket-perforated me-1"></i>Đặt vé
                </a>
                <a class="nav-link" href="index.php?controller=admin&action=boats">
                    <i class="bi bi-water me-1"></i>Ghe
                </a>
                <a class="nav-link" href="index.php?controller=admin&action=reports">
                    <i class="bi bi-graph-up me-1"></i>Báo cáo
                </a>
            </div>
            
            <!-- User Menu -->
            <div class="navbar-nav">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1"></i>
                        <?php echo htmlspecialchars($_SESSION['admin_fullname']); ?>
                    </a>
                    <ul class="dropdown-menu">
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
            <h5 class="text-white">Quản lý hệ thống</h5>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white" href="index.php?controller=admin&action=dashboard">
                    <i class="bi bi-speedometer2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="index.php?controller=admin&action=customers">
                    <i class="bi bi-people"></i>Khách hàng
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="index.php?controller=admin&action=boats">
                    <i class="bi bi-water"></i>Quản lý ghe
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="index.php?controller=admin&action=trips">
                    <i class="bi bi-calendar-event"></i>Chuyến đi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active text-white" href="index.php?controller=admin&action=bookings">
                    <i class="bi bi-ticket-perforated"></i>Đặt vé
                </a>
            </li>


            <li class="nav-item mt-4">
                <a class="nav-link text-white" href="index.php?controller=admin&action=logout">
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
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="bi bi-ticket-perforated text-primary" style="font-size: 2.5rem;"></i>
                            </div>
                            <div>
                                <h1 class="mb-1 text-dark">Quản lý Đặt vé</h1>
                                <p class="mb-0 text-muted">Quản lý tất cả đặt vé trong hệ thống</p>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary" onclick="exportBookings()">
                                <i class="bi bi-download me-1"></i>Xuất Excel
                            </button>
                            <button class="btn btn-primary" onclick="refreshData()">
                                <i class="bi bi-arrow-clockwise me-1"></i>Làm mới
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Trạng thái</label>
                            <select class="form-select" id="statusFilter">
                                <option value="">Tất cả</option>
                                <option value="pending">Chờ xác nhận</option>
                                <option value="confirmed">Đã xác nhận</option>
                                <option value="completed">Đã hoàn thành</option>
                                <option value="cancelled">Đã hủy</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Từ ngày</label>
                            <input type="date" class="form-control" id="startDate">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Đến ngày</label>
                            <input type="date" class="form-control" id="endDate">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tìm kiếm</label>
                            <input type="text" class="form-control" id="searchInput" placeholder="Mã vé, tên khách...">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bookings Table -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Danh sách đặt vé</h5>
                        <div class="d-flex gap-2">
                            <span class="badge bg-primary"><?php echo $total_bookings; ?> đặt vé</span>
                        </div>
                    </div>
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
                                    <th>Số vé</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($bookings) && count($bookings) > 0): ?>
                                    <?php foreach ($bookings as $booking): ?>
                                        <?php 
                                        // Lấy thông tin route từ bảng routes
                                        $routeQuery = "SELECT route_name FROM routes WHERE route_code = :route_code";
                                        $routeStmt = $conn->prepare($routeQuery);
                                        $routeStmt->bindParam(":route_code", $booking['route']);
                                        $routeStmt->execute();
                                        $routeData = $routeStmt->fetch(PDO::FETCH_ASSOC);
                                        $routeName = $routeData ? $routeData['route_name'] : $booking['route'];
                                        
                                        $statusClass = '';
                                        $statusText = '';
                                        switch($booking['status']) {
                                            case 'pending':
                                                $statusClass = 'bg-warning';
                                                $statusText = 'Chờ xác nhận';
                                                break;
                                            case 'confirmed':
                                                $statusClass = 'bg-success';
                                                $statusText = 'Đã xác nhận';
                                                break;
                                            case 'completed':
                                                $statusClass = 'bg-info';
                                                $statusText = 'Đã hoàn thành';
                                                break;
                                            case 'cancelled':
                                                $statusClass = 'bg-danger';
                                                $statusText = 'Đã hủy';
                                                break;
                                        }
                                        ?>
                                        <tr>
                                            <td><strong>#<?php echo str_pad($booking['id'], 3, '0', STR_PAD_LEFT); ?></strong></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2" style="width: 35px; height: 35px; background: #667eea; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                                                        <?php echo substr($booking['passenger_name'], 0, 1); ?>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold"><?php echo htmlspecialchars($booking['passenger_name']); ?></div>
                                                        <small class="text-muted"><?php echo htmlspecialchars($booking['phone']); ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo htmlspecialchars($routeName); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($booking['departure_date'])); ?></td>
                                            <td>
                                                <div>
                                                    <span class="badge bg-primary"><?php echo $booking['adult_tickets']; ?> người lớn</span>
                                                    <?php if ($booking['child_tickets'] > 0): ?>
                                                        <span class="badge bg-info"><?php echo $booking['child_tickets']; ?> trẻ em</span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td><strong><?php echo number_format($booking['total_price']); ?>đ</strong></td>
                                            <td><span class="badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($booking['created_at'])); ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="index.php?controller=admin&action=view_booking&id=<?php echo $booking['id']; ?>" 
                                                       class="btn btn-outline-primary btn-sm">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <?php if ($booking['status'] == 'pending'): ?>
                                                        <button class="btn btn-outline-success btn-sm" onclick="confirmBooking(<?php echo $booking['id']; ?>)">
                                                            <i class="bi bi-check"></i>
                                                        </button>
                                                        <button class="btn btn-outline-danger btn-sm" onclick="cancelBooking(<?php echo $booking['id']; ?>)">
                                                            <i class="bi bi-x"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                            <h5>Chưa có đặt vé nào</h5>
                                            <p class="mb-0">Khách hàng sẽ xuất hiện ở đây khi họ đặt vé</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <?php if (isset($total_pages) && $total_pages > 1): ?>
                        <nav aria-label="Page navigation" class="mt-4">
                            <ul class="pagination justify-content-center">
                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                        <a class="page-link" href="index.php?controller=admin&action=bookings&page=<?php echo $i; ?>">
                                            <?php echo $i; ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Sidebar Toggle Script -->
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }

        function confirmBooking(bookingId) {
            if (confirm('Xác nhận đặt vé này?')) {
                // Gửi request xác nhận
                fetch('index.php?controller=admin&action=confirm_booking&id=' + bookingId, {
                    method: 'POST'
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Có lỗi xảy ra: ' + data.message);
                    }
                });
            }
        }

        function cancelBooking(bookingId) {
            if (confirm('Hủy đặt vé này?')) {
                // Gửi request hủy
                fetch('index.php?controller=admin&action=cancel_booking&id=' + bookingId, {
                    method: 'POST'
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Có lỗi xảy ra: ' + data.message);
                    }
                });
            }
        }

        function exportBookings() {
            // Xuất Excel
            window.open('index.php?controller=admin&action=export_bookings', '_blank');
        }

        function refreshData() {
            location.reload();
        }
    </script>
</body>
</html> 