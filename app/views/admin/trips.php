<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Chuyến đi - Admin</title>
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
        
        .status-scheduled { background: #d1ecf1; color: #0c5460; }
        .status-boarding { background: #fff3cd; color: #856404; }
        .status-departed { background: #d4edda; color: #155724; }
        .status-arrived { background: #cce5ff; color: #004085; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        
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
                <a class="nav-link active" href="admin.php?action=trips">
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
                    <h1 class="h3 mb-0">Quản lý Chuyến đi</h1>
                    <p class="text-muted">Quản lý lịch trình và trạng thái chuyến đi</p>
                </div>
                <div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTripModal">
                        <i class="bi bi-plus-circle me-2"></i>Tạo chuyến mới
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
                                <input type="text" class="form-control" id="searchInput" placeholder="Tìm kiếm chuyến đi...">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="statusFilter">
                                <option value="">Tất cả trạng thái</option>
                                <option value="scheduled">Đã lên lịch</option>
                                <option value="boarding">Đang lên tàu</option>
                                <option value="departed">Đã khởi hành</option>
                                <option value="arrived">Đã đến</option>
                                <option value="cancelled">Đã hủy</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" class="form-control" id="dateFilter">
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="boatFilter">
                                <option value="">Tất cả ghe</option>
                                <option value="1">GH001 - Ghe Ninh Kiều 1</option>
                                <option value="2">GH002 - Ghe Cái Răng 1</option>
                                <option value="3">GH003 - Ghe An Bình 1</option>
                                <option value="4">GH004 - Ghe Phong Điền 1</option>
                                <option value="5">GH005 - Ghe Cù Lao Mây 1</option>
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

            <!-- Trips Table -->
            <div class="content-card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-calendar-event me-2"></i>Danh sách chuyến đi
                        </h5>
                        <span class="badge bg-primary">5 chuyến đi</span>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Mã chuyến</th>
                                <th>Ghe</th>
                                <th>Tuyến đường</th>
                                <th>Ngày giờ khởi hành</th>
                                <th>Ghế đã đặt</th>
                                <th>Ghế còn trống</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>TR001</strong></td>
                                <td>GH001 - Ghe Ninh Kiều 1</td>
                                <td>Bến Ninh Kiều → Chợ nổi Cái Răng</td>
                                <td>15/01/2025 08:00</td>
                                <td><span class="text-warning">25/50</span></td>
                                <td><span class="text-success">25</span></td>
                                <td><span class="status-badge status-scheduled">Đã lên lịch</span></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-outline-primary btn-action" onclick="editTrip('TR001')" title="Chỉnh sửa">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-warning btn-action" onclick="updateStatus('TR001', 'boarding')" title="Lên tàu">
                                            <i class="bi bi-arrow-up-circle"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger btn-action" onclick="cancelTrip('TR001')" title="Hủy chuyến">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>TR002</strong></td>
                                <td>GH002 - Ghe Cái Răng 1</td>
                                <td>Chợ An Bình → Chợ nổi Cái Răng</td>
                                <td>15/01/2025 10:00</td>
                                <td><span class="text-warning">15/40</span></td>
                                <td><span class="text-success">25</span></td>
                                <td><span class="status-badge status-scheduled">Đã lên lịch</span></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-outline-primary btn-action" onclick="editTrip('TR002')" title="Chỉnh sửa">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-warning btn-action" onclick="updateStatus('TR002', 'boarding')" title="Lên tàu">
                                            <i class="bi bi-arrow-up-circle"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger btn-action" onclick="cancelTrip('TR002')" title="Hủy chuyến">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>TR003</strong></td>
                                <td>GH003 - Ghe An Bình 1</td>
                                <td>Bến Ninh Kiều → Chợ nổi Cái Răng</td>
                                <td>15/01/2025 14:00</td>
                                <td><span class="text-danger">30/35</span></td>
                                <td><span class="text-warning">5</span></td>
                                <td><span class="status-badge status-boarding">Đang lên tàu</span></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-outline-primary btn-action" onclick="editTrip('TR003')" title="Chỉnh sửa">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-success btn-action" onclick="updateStatus('TR003', 'departed')" title="Khởi hành">
                                            <i class="bi bi-play-circle"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger btn-action" onclick="cancelTrip('TR003')" title="Hủy chuyến">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>TR004</strong></td>
                                <td>GH005 - Ghe Cù Lao Mây 1</td>
                                <td>Bến Ninh Kiều → Cù Lao Mây</td>
                                <td>16/01/2025 06:00</td>
                                <td><span class="text-warning">45/60</span></td>
                                <td><span class="text-success">15</span></td>
                                <td><span class="status-badge status-scheduled">Đã lên lịch</span></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-outline-primary btn-action" onclick="editTrip('TR004')" title="Chỉnh sửa">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-warning btn-action" onclick="updateStatus('TR004', 'boarding')" title="Lên tàu">
                                            <i class="bi bi-arrow-up-circle"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger btn-action" onclick="cancelTrip('TR004')" title="Hủy chuyến">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>TR005</strong></td>
                                <td>GH001 - Ghe Ninh Kiều 1</td>
                                <td>Chợ nổi Cái Răng → Phong Điền</td>
                                <td>16/01/2025 08:00</td>
                                <td><span class="text-success">0/50</span></td>
                                <td><span class="text-success">50</span></td>
                                <td><span class="status-badge status-scheduled">Đã lên lịch</span></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-outline-primary btn-action" onclick="editTrip('TR005')" title="Chỉnh sửa">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-warning btn-action" onclick="updateStatus('TR005', 'boarding')" title="Lên tàu">
                                            <i class="bi bi-arrow-up-circle"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger btn-action" onclick="cancelTrip('TR005')" title="Hủy chuyến">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Trip Modal -->
    <div class="modal fade" id="addTripModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle me-2"></i>Tạo chuyến mới
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="admin.php?action=add_trip">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Mã chuyến <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="trip_code" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Ghe <span class="text-danger">*</span></label>
                                    <select class="form-select" name="boat_id" required>
                                        <option value="">Chọn ghe</option>
                                        <option value="1">GH001 - Ghe Ninh Kiều 1 (50 chỗ)</option>
                                        <option value="2">GH002 - Ghe Cái Răng 1 (40 chỗ)</option>
                                        <option value="3">GH003 - Ghe An Bình 1 (35 chỗ)</option>
                                        <option value="4">GH004 - Ghe Phong Điền 1 (45 chỗ)</option>
                                        <option value="5">GH005 - Ghe Cù Lao Mây 1 (60 chỗ)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tuyến đường <span class="text-danger">*</span></label>
                                    <select class="form-select" name="route_id" required>
                                        <option value="">Chọn tuyến đường</option>
                                        <option value="1">Bến Ninh Kiều → Chợ nổi Cái Răng</option>
                                        <option value="2">Chợ An Bình → Chợ nổi Cái Răng</option>
                                        <option value="3">Bến Ninh Kiều → Cù Lao Mây</option>
                                        <option value="4">Chợ nổi Cái Răng → Phong Điền</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Ngày khởi hành <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="departure_date" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Giờ khởi hành <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" name="departure_time" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Trạng thái</label>
                                    <select class="form-select" name="status">
                                        <option value="scheduled">Đã lên lịch</option>
                                        <option value="boarding">Đang lên tàu</option>
                                        <option value="departed">Đã khởi hành</option>
                                        <option value="arrived">Đã đến</option>
                                        <option value="cancelled">Đã hủy</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Tạo chuyến</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Cancel Trip Modal -->
    <div class="modal fade" id="cancelTripModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-triangle text-danger me-2"></i>Xác nhận hủy chuyến
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn hủy chuyến <strong id="tripCode"></strong>?</p>
                    <p class="text-muted small">Hành động này sẽ hủy tất cả vé đã đặt cho chuyến này.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <form method="POST" action="admin.php?action=cancel_trip" style="display: inline;">
                        <input type="hidden" name="trip_id" id="tripId">
                        <button type="submit" class="btn btn-danger">Hủy chuyến</button>
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
            const boatFilter = document.getElementById('boatFilter').value;
            
            // Lọc theo trạng thái
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const status = row.querySelector('.status-badge').textContent;
                const date = row.querySelector('td:nth-child(3)').textContent;
                const boat = row.querySelector('td:nth-child(2)').textContent;
                
                let show = true;
                if (statusFilter && status !== statusFilter) show = false;
                if (dateFilter && !date.includes(dateFilter)) show = false;
                if (boatFilter && !boat.includes(boatFilter)) show = false;
                
                row.style.display = show ? '' : 'none';
            });
        }

        // Reset filters
        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('dateFilter').value = '';
            document.getElementById('boatFilter').value = '';
            
            // Show all rows
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => row.style.display = '');
        }

        // Edit trip
        function editTrip(tripCode) {
            window.location.href = `admin.php?action=edit_trip&id=${tripCode}`;
        }

        // Update trip status
        function updateStatus(tripCode, status) {
            if (confirm('Bạn có chắc chắn muốn cập nhật trạng thái chuyến đi này?')) {
                window.location.href = `admin.php?action=update_trip_status&id=${tripCode}&status=${status}`;
            }
        }

        // Cancel trip confirmation
        function cancelTrip(tripCode) {
            document.getElementById('tripCode').textContent = tripCode;
            document.getElementById('tripId').value = tripCode;
            new bootstrap.Modal(document.getElementById('cancelTripModal')).show();
        }
    </script>
</body>
</html> 