<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Hóa đơn - Admin</title>
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
        
        .table th {
            background: #f8f9fa;
            border-top: none;
            font-weight: 600;
        }
        
        .btn-action {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        
        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-pending { background: #fff3cd; color: #856404; }
        .status-paid { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        .status-refunded { background: #e2e3e5; color: #383d41; }
        
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
                <a class="nav-link active" href="admin.php?action=invoices">
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
                    <h1 class="h3 mb-0">Quản lý Hóa đơn</h1>
                    <p class="text-muted">Quản lý hóa đơn và trạng thái thanh toán</p>
                </div>
                <div>
                    <button class="btn btn-success me-2" onclick="exportInvoices()">
                        <i class="bi bi-download me-2"></i>Xuất Excel
                    </button>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addInvoiceModal">
                        <i class="bi bi-plus-circle me-2"></i>Tạo hóa đơn
                    </button>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="content-card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control" id="searchInput" placeholder="Tìm kiếm hóa đơn...">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="statusFilter">
                                <option value="">Tất cả trạng thái</option>
                                <option value="pending">Chờ thanh toán</option>
                                <option value="paid">Đã thanh toán</option>
                                <option value="cancelled">Đã hủy</option>
                                <option value="refunded">Đã hoàn tiền</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" class="form-control" id="dateFilter">
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="paymentMethodFilter">
                                <option value="">Tất cả phương thức</option>
                                <option value="cash">Tiền mặt</option>
                                <option value="bank_transfer">Chuyển khoản</option>
                                <option value="credit_card">Thẻ tín dụng</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-outline-primary me-2" onclick="applyFilters()">
                                <i class="bi bi-funnel me-1"></i>Lọc
                            </button>
                            <button class="btn btn-outline-secondary" onclick="resetFilters()">
                                <i class="bi bi-arrow-clockwise me-1"></i>Làm mới
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoices Table -->
            <div class="content-card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-receipt me-2"></i>Danh sách hóa đơn
                        </h5>
                        <span class="badge bg-primary">0 hóa đơn</span>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Mã hóa đơn</th>
                                <th>Khách hàng</th>
                                <th>Mã vé</th>
                                <th>Chuyến đi</th>
                                <th>Tổng tiền</th>
                                <th>Phương thức</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="bi bi-inbox display-4 text-muted"></i>
                                    <p class="text-muted mt-2">Không có hóa đơn nào</p>
                                    <p class="text-muted small">Hóa đơn sẽ được tạo tự động khi vé được xác nhận thanh toán</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Sample Invoice (for demonstration) -->
            <div class="content-card mt-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>Mẫu hóa đơn
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Thông tin hóa đơn</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Mã hóa đơn:</strong></td>
                                    <td>INV001</td>
                                </tr>
                                <tr>
                                    <td><strong>Khách hàng:</strong></td>
                                    <td>Nguyễn Văn A</td>
                                </tr>
                                <tr>
                                    <td><strong>Mã vé:</strong></td>
                                    <td>#000001</td>
                                </tr>
                                <tr>
                                    <td><strong>Chuyến đi:</strong></td>
                                    <td>TR001 - Ninh Kiều → Cái Răng</td>
                                </tr>
                                <tr>
                                    <td><strong>Ngày đi:</strong></td>
                                    <td>15/01/2025 08:00</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Chi tiết thanh toán</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Giá vé người lớn:</strong></td>
                                    <td>150.000đ x 2 = 300.000đ</td>
                                </tr>
                                <tr>
                                    <td><strong>Giá vé trẻ em:</strong></td>
                                    <td>75.000đ x 1 = 75.000đ</td>
                                </tr>
                                <tr>
                                    <td><strong>Thuế (10%):</strong></td>
                                    <td>37.500đ</td>
                                </tr>
                                <tr>
                                    <td><strong>Giảm giá:</strong></td>
                                    <td>0đ</td>
                                </tr>
                                <tr class="table-primary">
                                    <td><strong>Tổng cộng:</strong></td>
                                    <td><strong>412.500đ</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="status-badge status-paid">Đã thanh toán</span>
                                    <small class="text-muted ms-2">Chuyển khoản - 14/01/2025 15:30</small>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-outline-primary me-2">
                                        <i class="bi bi-eye me-1"></i>Xem chi tiết
                                    </button>
                                    <button class="btn btn-sm btn-outline-success me-2">
                                        <i class="bi bi-printer me-1"></i>In hóa đơn
                                    </button>
                                    <button class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-envelope me-1"></i>Gửi email
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
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

        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Apply filters
        function applyFilters() {
            const statusFilter = document.getElementById('statusFilter').value;
            const dateFilter = document.getElementById('dateFilter').value;
            const paymentMethodFilter = document.getElementById('paymentMethodFilter').value;
            
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const status = row.querySelector('.status-badge').textContent;
                const date = row.querySelector('td:nth-child(3)').textContent;
                const payment = row.querySelector('td:nth-child(5)').textContent;
                
                let show = true;
                if (statusFilter && status !== statusFilter) show = false;
                if (dateFilter && !date.includes(dateFilter)) show = false;
                if (paymentMethodFilter && !payment.includes(paymentMethodFilter)) show = false;
                
                row.style.display = show ? '' : 'none';
            });
        }

        // Reset filters
        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('dateFilter').value = '';
            document.getElementById('paymentMethodFilter').value = '';
            
            // Show all rows
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => row.style.display = '');
        }

        // Export invoices to Excel
        function exportInvoices() {
            window.location.href = 'admin.php?action=export_invoices';
        }
    </script>
</body>
</html> 