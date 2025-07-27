<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết Khách hàng - Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
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
        
        .customer-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
            margin: 0 auto 1rem;
        }
        
        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .stats-number {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-color);
        }
        
        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-active { background: #d4edda; color: #155724; }
        .status-inactive { background: #f8d7da; color: #721c24; }
        
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
                <a class="nav-link active" href="admin.php?action=customers">
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
    <div class="main-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="admin.php?action=customers" class="text-decoration-none">
                                    <i class="bi bi-people me-1"></i>Khách hàng
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Chi tiết</li>
                        </ol>
                    </nav>
                    <h1 class="h3 mb-0 mt-2">Chi tiết Khách hàng</h1>
                </div>
                <div>
                    <a href="admin.php?action=customers" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-arrow-left me-2"></i>Quay lại
                    </a>
                    <button class="btn btn-danger" onclick="deleteCustomer(<?php echo $customer['id']; ?>, '<?php echo htmlspecialchars($customer['fullname']); ?>')">
                        <i class="bi bi-trash me-2"></i>Xóa khách hàng
                    </button>
                </div>
            </div>

            <div class="row">
                <!-- Customer Information -->
                <div class="col-lg-4">
                    <div class="content-card">
                        <div class="card-body text-center">
                            <div class="customer-avatar">
                                <i class="bi bi-person"></i>
                            </div>
                            <h4><?php echo htmlspecialchars($customer['fullname']); ?></h4>
                            <p class="text-muted">@<?php echo htmlspecialchars($customer['username']); ?></p>
                            <span class="status-badge status-active">Hoạt động</span>
                        </div>
                        
                        <div class="card-body border-top">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="stats-card">
                                        <div class="stats-number"><?php echo count($bookings); ?></div>
                                        <small class="text-muted">Tổng đặt vé</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stats-card">
                                        <div class="stats-number">
                                            <?php 
                                            $totalSpent = array_sum(array_column($bookings, 'total_price'));
                                            echo number_format($totalSpent);
                                            ?>
                                        </div>
                                        <small class="text-muted">Tổng chi tiêu (VNĐ)</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="content-card mt-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">
                                <i class="bi bi-person-lines-fill me-2"></i>Thông tin liên hệ
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted">Email</label>
                                <p class="mb-0">
                                    <i class="bi bi-envelope me-2"></i>
                                    <?php echo htmlspecialchars($customer['email']); ?>
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Số điện thoại</label>
                                <p class="mb-0">
                                    <i class="bi bi-telephone me-2"></i>
                                    <?php echo htmlspecialchars($customer['phone']); ?>
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Địa chỉ</label>
                                <p class="mb-0">
                                    <i class="bi bi-geo-alt me-2"></i>
                                    <?php echo htmlspecialchars($customer['address']); ?>
                                </p>
                            </div>
                            <div class="mb-0">
                                <label class="form-label text-muted">Ngày tham gia</label>
                                <p class="mb-0">
                                    <i class="bi bi-calendar me-2"></i>
                                    <?php echo date('d/m/Y H:i', strtotime($customer['created_at'])); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking History -->
                <div class="col-lg-8">
                    <div class="content-card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">
                                <i class="bi bi-clock-history me-2"></i>Lịch sử đặt vé
                            </h5>
                        </div>
                        
                        <?php if (empty($bookings)): ?>
                            <div class="card-body text-center py-5">
                                <i class="bi bi-inbox display-4 text-muted"></i>
                                <p class="text-muted mt-2">Khách hàng chưa có lịch sử đặt vé</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Mã vé</th>
                                            <th>Tuyến đường</th>
                                            <th>Ngày đi</th>
                                            <th>Số vé</th>
                                            <th>Tổng tiền</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày đặt</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($bookings as $booking): ?>
                                            <tr>
                                                <td>
                                                    <strong>#<?php echo str_pad($booking['id'], 6, '0', STR_PAD_LEFT); ?></strong>
                                                </td>
                                                <td>
                                                    <?php 
                                                    $routeNames = [
                                                        'ninh_kieu_cai_rang' => 'Ninh Kiều → Cái Răng',
                                                        'an_binh_cai_rang' => 'An Bình → Cái Răng',
                                                        'ninh_kieu_cu_lao_may' => 'Ninh Kiều → Cù Lao Mây',
                                                        'cai_rang_phong_dien' => 'Cái Răng → Phong Điền'
                                                    ];
                                                    echo $routeNames[$booking['route']] ?? $booking['route'];
                                                    ?>
                                                </td>
                                                <td><?php echo date('d/m/Y H:i', strtotime($booking['departure_date'] . ' ' . $booking['departure_time'])); ?></td>
                                                <td>
                                                    <?php 
                                                    $totalTickets = $booking['adult_tickets'] + $booking['child_tickets'];
                                                    echo $totalTickets . ' vé';
                                                    if ($booking['adult_tickets'] > 0) echo ' (' . $booking['adult_tickets'] . ' người lớn';
                                                    if ($booking['child_tickets'] > 0) echo ', ' . $booking['child_tickets'] . ' trẻ em';
                                                    if ($booking['adult_tickets'] > 0 || $booking['child_tickets'] > 0) echo ')';
                                                    ?>
                                                </td>
                                                <td>
                                                    <strong><?php echo number_format($booking['total_price']); ?>đ</strong>
                                                </td>
                                                <td>
                                                    <?php 
                                                    $statusColors = [
                                                        'pending' => 'warning',
                                                        'confirmed' => 'success',
                                                        'completed' => 'primary',
                                                        'cancelled' => 'danger'
                                                    ];
                                                    $statusLabels = [
                                                        'pending' => 'Chờ xác nhận',
                                                        'confirmed' => 'Đã xác nhận',
                                                        'completed' => 'Hoàn tất',
                                                        'cancelled' => 'Đã hủy'
                                                    ];
                                                    $color = $statusColors[$booking['status']] ?? 'secondary';
                                                    $label = $statusLabels[$booking['status']] ?? $booking['status'];
                                                    ?>
                                                    <span class="badge bg-<?php echo $color; ?>"><?php echo $label; ?></span>
                                                </td>
                                                <td><?php echo date('d/m/Y H:i', strtotime($booking['created_at'])); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Booking Statistics -->
                    <?php if (!empty($bookings)): ?>
                        <div class="content-card mt-4">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">
                                    <i class="bi bi-graph-up me-2"></i>Thống kê đặt vé
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <div class="stats-number text-success">
                                                <?php echo count(array_filter($bookings, fn($b) => $b['status'] === 'confirmed')); ?>
                                            </div>
                                            <small class="text-muted">Đã xác nhận</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <div class="stats-number text-warning">
                                                <?php echo count(array_filter($bookings, fn($b) => $b['status'] === 'pending')); ?>
                                            </div>
                                            <small class="text-muted">Chờ xác nhận</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <div class="stats-number text-primary">
                                                <?php echo count(array_filter($bookings, fn($b) => $b['status'] === 'completed')); ?>
                                            </div>
                                            <small class="text-muted">Hoàn tất</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <div class="stats-number text-danger">
                                                <?php echo count(array_filter($bookings, fn($b) => $b['status'] === 'cancelled')); ?>
                                            </div>
                                            <small class="text-muted">Đã hủy</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-triangle text-danger me-2"></i>Xác nhận xóa
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa khách hàng <strong id="customerName"></strong>?</p>
                    <p class="text-muted small">Hành động này không thể hoàn tác.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <form method="POST" action="admin.php?action=delete_customer" style="display: inline;">
                        <input type="hidden" name="customer_id" id="customerId">
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
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

        // Delete customer confirmation
        function deleteCustomer(customerId, customerName) {
            document.getElementById('customerId').value = customerId;
            document.getElementById('customerName').textContent = customerName;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }
    </script>
</body>
</html> 