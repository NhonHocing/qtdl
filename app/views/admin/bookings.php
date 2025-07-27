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
        .status-confirmed { background: #d4edda; color: #155724; }
        .status-completed { background: #cce5ff; color: #004085; }
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
                <a class="nav-link" href="admin.php?action=trips">
                    <i class="bi bi-calendar-event"></i>Chuyến đi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="admin.php?action=bookings">
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
                    <h1 class="h3 mb-0">Quản lý Đặt vé</h1>
                    <p class="text-muted">Quản lý tất cả đặt vé và trạng thái thanh toán</p>
                </div>
                <div>
                    <button class="btn btn-success me-2" onclick="exportBookings()">
                        <i class="bi bi-download me-2"></i>Xuất Excel
                    </button>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBookingModal">
                        <i class="bi bi-plus-circle me-2"></i>Thêm đặt vé
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
                                <input type="text" class="form-control" id="searchInput" placeholder="Tìm kiếm đặt vé...">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="statusFilter">
                                <option value="">Tất cả trạng thái</option>
                                <option value="pending">Chờ xác nhận</option>
                                <option value="confirmed">Đã xác nhận</option>
                                <option value="completed">Hoàn tất</option>
                                <option value="cancelled">Đã hủy</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" class="form-control" id="dateFilter">
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="customerFilter">
                                <option value="">Tất cả khách hàng</option>
                                <option value="1">Nguyễn Văn A</option>
                                <option value="2">Trần Thị B</option>
                                <option value="3">Lê Văn C</option>
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

            <!-- Bookings Table -->
            <div class="content-card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-ticket me-2"></i>Danh sách đặt vé
                        </h5>
                        <span class="badge bg-primary"><?php echo $total_bookings; ?> đặt vé</span>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Mã vé</th>
                                <th>Khách hàng</th>
                                <th>Tuyến đường</th>
                                <th>Ngày đi</th>
                                <th>Số vé</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Ngày đặt</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($bookings)): ?>
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <i class="bi bi-inbox display-4 text-muted"></i>
                                        <p class="text-muted mt-2">Không có đặt vé nào</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($bookings as $booking): ?>
                                    <tr>
                                        <td>
                                            <strong>#<?php echo str_pad($booking['id'], 6, '0', STR_PAD_LEFT); ?></strong>
                                        </td>
                                        <td>
                                            <div>
                                                <strong><?php echo htmlspecialchars($booking['customer_name']); ?></strong>
                                                <br>
                                                <small class="text-muted"><?php echo htmlspecialchars($booking['customer_phone']); ?></small>
                                            </div>
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
                                                'pending' => 'pending',
                                                'confirmed' => 'confirmed',
                                                'completed' => 'completed',
                                                'cancelled' => 'cancelled'
                                            ];
                                            $statusLabels = [
                                                'pending' => 'Chờ xác nhận',
                                                'confirmed' => 'Đã xác nhận',
                                                'completed' => 'Hoàn tất',
                                                'cancelled' => 'Đã hủy'
                                            ];
                                            $color = $statusColors[$booking['status']] ?? 'pending';
                                            $label = $statusLabels[$booking['status']] ?? $booking['status'];
                                            ?>
                                            <span class="status-badge status-<?php echo $color; ?>"><?php echo $label; ?></span>
                                        </td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($booking['created_at'])); ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary btn-action" onclick="viewBooking(<?php echo $booking['id']; ?>)" title="Xem chi tiết">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <?php if ($booking['status'] === 'pending'): ?>
                                                    <button class="btn btn-sm btn-outline-success btn-action" onclick="confirmBooking(<?php echo $booking['id']; ?>)" title="Xác nhận">
                                                        <i class="bi bi-check-circle"></i>
                                                    </button>
                                                <?php endif; ?>
                                                <?php if (in_array($booking['status'], ['pending', 'confirmed'])): ?>
                                                    <button class="btn btn-sm btn-outline-danger btn-action" onclick="cancelBooking(<?php echo $booking['id']; ?>)" title="Hủy vé">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                <?php endif; ?>
                                                <button class="btn btn-sm btn-outline-info btn-action" onclick="printTicket(<?php echo $booking['id']; ?>)" title="In vé">
                                                    <i class="bi bi-printer"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                    <div class="card-footer bg-white">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center mb-0">
                                <?php if ($page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?action=bookings&page=<?php echo $page - 1; ?>">
                                            <i class="bi bi-chevron-left"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                
                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                                        <a class="page-link" href="?action=bookings&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                                
                                <?php if ($page < $total_pages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?action=bookings&page=<?php echo $page + 1; ?>">
                                            <i class="bi bi-chevron-right"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Cancel Booking Modal -->
    <div class="modal fade" id="cancelBookingModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-triangle text-danger me-2"></i>Xác nhận hủy vé
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn hủy vé <strong id="bookingId"></strong>?</p>
                    <p class="text-muted small">Hành động này không thể hoàn tác.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <form method="POST" action="admin.php?action=cancel_booking" style="display: inline;">
                        <input type="hidden" name="booking_id" id="cancelBookingId">
                        <button type="submit" class="btn btn-danger">Hủy vé</button>
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
            const customerFilter = document.getElementById('customerFilter').value;
            
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const status = row.querySelector('.status-badge').textContent;
                const date = row.querySelector('td:nth-child(4)').textContent;
                const customer = row.querySelector('td:nth-child(2)').textContent;
                
                let show = true;
                if (statusFilter && status !== statusFilter) show = false;
                if (dateFilter && !date.includes(dateFilter)) show = false;
                if (customerFilter && !customer.includes(customerFilter)) show = false;
                
                row.style.display = show ? '' : 'none';
            });
        }

        // Reset filters
        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('dateFilter').value = '';
            document.getElementById('customerFilter').value = '';
            
            // Show all rows
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => row.style.display = '');
        }

        // View booking details
        function viewBooking(bookingId) {
            window.location.href = `admin.php?action=view_booking&id=${bookingId}`;
        }

        // Confirm booking
        function confirmBooking(bookingId) {
            if (confirm('Bạn có chắc chắn muốn xác nhận đặt vé này?')) {
                window.location.href = `admin.php?action=confirm_booking&id=${bookingId}`;
            }
        }

        // Cancel booking confirmation
        function cancelBooking(bookingId) {
            document.getElementById('bookingId').textContent = '#' + String(bookingId).padStart(6, '0');
            document.getElementById('cancelBookingId').value = bookingId;
            new bootstrap.Modal(document.getElementById('cancelBookingModal')).show();
        }

        // Print ticket
        function printTicket(bookingId) {
            window.open(`admin.php?action=print_ticket&id=${bookingId}`, '_blank');
        }

        // Export bookings to Excel
        function exportBookings() {
            window.location.href = 'admin.php?action=export_bookings';
        }
    </script>
</body>
</html> 