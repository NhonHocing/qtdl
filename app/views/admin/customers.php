<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Khách hàng - Admin</title>
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
                <a class="nav-link" href="index.php?controller=admin&action=dashboard">
                    <i class="bi bi-speedometer2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="index.php?controller=admin&action=customers">
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
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="mb-1">Quản lý Khách hàng</h1>
                            <p class="mb-0 text-muted">Danh sách khách hàng đã đăng ký và đặt vé</p>
                        </div>
                        <div>
                            <button class="btn btn-primary" onclick="exportCustomers()">
                                <i class="bi bi-download me-2"></i>Xuất Excel
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="card-icon primary">
                                    <i class="bi bi-people"></i>
                                </div>
                            </div>
                            <div>
                                <div class="card-title">Tổng khách hàng</div>
                                <div class="card-value"><?php echo number_format($stats['total_customers'] ?? 0); ?></div>
                                <div class="card-change">Tất cả khách hàng đã đăng ký</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="card-icon success">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                            </div>
                            <div>
                                <div class="card-title">Khách hàng hoạt động</div>
                                <div class="card-value"><?php echo number_format($stats['active_customers'] ?? 0); ?></div>
                                <div class="card-change">Tài khoản đang hoạt động</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="card-icon warning">
                                    <i class="bi bi-person-plus"></i>
                                </div>
                            </div>
                            <div>
                                <div class="card-title">Khách hàng mới</div>
                                <div class="card-value"><?php echo number_format($stats['new_customers'] ?? 0); ?></div>
                                <div class="card-change">Đăng ký trong 30 ngày qua</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="card-icon danger">
                                    <i class="bi bi-ticket-perforated"></i>
                                </div>
                            </div>
                            <div>
                                <div class="card-title">Tổng đặt vé</div>
                                <div class="card-value"><?php 
                                    $totalBookings = 0;
                                    foreach ($customers as $customer) {
                                        $totalBookings += $customer['total_bookings'];
                                    }
                                    echo number_format($totalBookings);
                                ?></div>
                                <div class="card-change">Từ tất cả khách hàng</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="searchInput" class="form-label">Tìm kiếm khách hàng</label>
                                <input type="text" class="form-control" id="searchInput" placeholder="Tên, email, số điện thoại...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="statusFilter" class="form-label">Trạng thái</label>
                                <select class="form-select" id="statusFilter">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="active">Hoạt động</option>
                                    <option value="inactive">Không hoạt động</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="bookingFilter" class="form-label">Số đặt vé</label>
                                <select class="form-select" id="bookingFilter">
                                    <option value="">Tất cả</option>
                                    <option value="0">Chưa đặt vé</option>
                                    <option value="1-5">1-5 vé</option>
                                    <option value="6-10">6-10 vé</option>
                                    <option value="10+">10+ vé</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid">
                                    <button class="btn btn-outline-secondary" onclick="resetFilters()">
                                        <i class="bi bi-arrow-clockwise me-1"></i>Làm mới
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customers Table -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Danh sách khách hàng</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($customers)): ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Thông tin</th>
                                        <th>Liên hệ</th>
                                        <th>Đặt vé</th>
                                        <th>Tổng chi</th>
                                        <th>Ngày đăng ký</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($customers as $customer): ?>
                                        <tr>
                                            <td><strong>#<?php echo $customer['id']; ?></strong></td>
                                            <td>
                                                <div>
                                                    <strong><?php echo htmlspecialchars($customer['fullname']); ?></strong>
                                                    <br>
                                                    <small class="text-muted">@<?php echo htmlspecialchars($customer['username']); ?></small>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <div><?php echo htmlspecialchars($customer['email']); ?></div>
                                                    <small class="text-muted"><?php echo htmlspecialchars($customer['phone']); ?></small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary"><?php echo $customer['total_bookings']; ?> vé</span>
                                            </td>
                                            <td>
                                                <strong><?php echo number_format($customer['total_spent'] ?? 0); ?> VNĐ</strong>
                                            </td>
                                            <td>
                                                <?php echo date('d/m/Y', strtotime($customer['created_at'])); ?>
                                            </td>
                                            <td>
                                                <?php if ($customer['status'] == 'active'): ?>
                                                    <span class="badge bg-success">Hoạt động</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Không hoạt động</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" onclick="viewCustomer(<?php echo $customer['id']; ?>)">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-info" onclick="editCustomer(<?php echo $customer['id']; ?>)">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" onclick="deleteCustomer(<?php echo $customer['id']; ?>, '<?php echo htmlspecialchars($customer['fullname']); ?>')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                            <h5 class="text-muted mt-3">Chưa có khách hàng nào</h5>
                            <p class="text-muted">Khách hàng sẽ xuất hiện ở đây khi họ đăng ký tài khoản</p>
                        </div>
                    <?php endif; ?>
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

        function viewCustomer(customerId) {
            window.location.href = `index.php?controller=admin&action=customer_detail&id=${customerId}`;
        }

        function editCustomer(customerId) {
            window.location.href = `index.php?controller=admin&action=edit_customer&id=${customerId}`;
        }

        function deleteCustomer(customerId, customerName) {
            if (confirm(`Bạn có chắc chắn muốn xóa khách hàng "${customerName}"?`)) {
                window.location.href = `index.php?controller=admin&action=delete_customer&id=${customerId}`;
            }
        }

        function exportCustomers() {
            window.location.href = `index.php?controller=admin&action=export_customers`;
        }

        // Tìm kiếm khách hàng
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('tbody tr');
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Lọc theo trạng thái
        document.getElementById('statusFilter').addEventListener('change', function() {
            applyFilters();
        });

        // Lọc theo số đặt vé
        document.getElementById('bookingFilter').addEventListener('change', function() {
            applyFilters();
        });

        function applyFilters() {
            const statusFilter = document.getElementById('statusFilter').value;
            const bookingFilter = document.getElementById('bookingFilter').value;
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            
            const tableRows = document.querySelectorAll('tbody tr');
            
            tableRows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const status = cells[6].textContent.toLowerCase();
                const bookings = parseInt(cells[3].textContent.split(' ')[0]);
                const text = row.textContent.toLowerCase();
                
                let show = true;
                
                // Lọc theo tìm kiếm
                if (searchTerm && !text.includes(searchTerm)) {
                    show = false;
                }
                
                // Lọc theo trạng thái
                if (statusFilter) {
                    if (statusFilter === 'active' && !status.includes('hoạt động')) show = false;
                    if (statusFilter === 'inactive' && !status.includes('không hoạt động')) show = false;
                }
                
                // Lọc theo số đặt vé
                if (bookingFilter) {
                    if (bookingFilter === '0' && bookings > 0) show = false;
                    if (bookingFilter === '1-5' && (bookings < 1 || bookings > 5)) show = false;
                    if (bookingFilter === '6-10' && (bookings < 6 || bookings > 10)) show = false;
                    if (bookingFilter === '10+' && bookings <= 10) show = false;
                }
                
                row.style.display = show ? '' : 'none';
            });
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('bookingFilter').value = '';
            
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach(row => {
                row.style.display = '';
            });
        }
    </script>
</body>
</html> 