<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Ghe - Admin</title>
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
        
        .boat-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            overflow: hidden;
        }
        
        .boat-card:hover {
            transform: translateY(-5px);
        }
        
        .boat-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 1rem;
            text-align: center;
        }
        
        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-active { background: #d4edda; color: #155724; }
        .status-maintenance { background: #fff3cd; color: #856404; }
        .status-full { background: #f8d7da; color: #721c24; }
        .status-inactive { background: #e2e3e5; color: #383d41; }
        
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
                <a class="nav-link active" href="admin.php?action=boats">
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
                    <h1 class="h3 mb-0">Quản lý Ghe</h1>
                    <p class="text-muted">Quản lý thông tin ghe và trạng thái hoạt động</p>
                </div>
                <div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBoatModal">
                        <i class="bi bi-plus-circle me-2"></i>Thêm ghe mới
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="content-card">
                        <div class="card-body text-center">
                            <div class="stats-icon stats-active mb-2">
                                <i class="bi bi-ship"></i>
                            </div>
                            <h3 class="mb-1">5</h3>
                            <p class="text-muted mb-0">Tổng số ghe</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="content-card">
                        <div class="card-body text-center">
                            <div class="stats-icon stats-active mb-2" style="background: #d4edda; color: #155724;">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <h3 class="mb-1">4</h3>
                            <p class="text-muted mb-0">Đang hoạt động</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="content-card">
                        <div class="card-body text-center">
                            <div class="stats-icon stats-maintenance mb-2" style="background: #fff3cd; color: #856404;">
                                <i class="bi bi-tools"></i>
                            </div>
                            <h3 class="mb-1">1</h3>
                            <p class="text-muted mb-0">Đang bảo trì</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="content-card">
                        <div class="card-body text-center">
                            <div class="stats-icon stats-full mb-2" style="background: #f8d7da; color: #721c24;">
                                <i class="bi bi-x-circle"></i>
                            </div>
                            <h3 class="mb-1">0</h3>
                            <p class="text-muted mb-0">Đầy chỗ</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boats Grid -->
            <div class="row">
                <!-- Sample Boat Cards -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="boat-card">
                        <div class="boat-header">
                            <h5 class="mb-1">GH001</h5>
                            <p class="mb-0">Ghe Ninh Kiều 1</p>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <small class="text-muted">Loại ghe</small>
                                    <p class="mb-0"><strong>Ghe khách</strong></p>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Sức chứa</small>
                                    <p class="mb-0"><strong>50 chỗ</strong></p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted">Mô tả</small>
                                <p class="mb-0">Ghe khách hiện đại, có điều hòa</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="status-badge status-active">Đang hoạt động</span>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-primary" onclick="editBoat(1)">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteBoat(1, 'GH001')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="boat-card">
                        <div class="boat-header">
                            <h5 class="mb-1">GH002</h5>
                            <p class="mb-0">Ghe Cái Răng 1</p>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <small class="text-muted">Loại ghe</small>
                                    <p class="mb-0"><strong>Ghe khách</strong></p>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Sức chứa</small>
                                    <p class="mb-0"><strong>40 chỗ</strong></p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted">Mô tả</small>
                                <p class="mb-0">Ghe khách phục vụ tuyến Cái Răng</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="status-badge status-active">Đang hoạt động</span>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-primary" onclick="editBoat(2)">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteBoat(2, 'GH002')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="boat-card">
                        <div class="boat-header">
                            <h5 class="mb-1">GH003</h5>
                            <p class="mb-0">Ghe An Bình 1</p>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <small class="text-muted">Loại ghe</small>
                                    <p class="mb-0"><strong>Ghe khách</strong></p>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Sức chứa</small>
                                    <p class="mb-0"><strong>35 chỗ</strong></p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted">Mô tả</small>
                                <p class="mb-0">Ghe khách phục vụ tuyến An Bình</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="status-badge status-active">Đang hoạt động</span>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-primary" onclick="editBoat(3)">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteBoat(3, 'GH003')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="boat-card">
                        <div class="boat-header">
                            <h5 class="mb-1">GH004</h5>
                            <p class="mb-0">Ghe Phong Điền 1</p>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <small class="text-muted">Loại ghe</small>
                                    <p class="mb-0"><strong>Ghe khách</strong></p>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Sức chứa</small>
                                    <p class="mb-0"><strong>45 chỗ</strong></p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted">Mô tả</small>
                                <p class="mb-0">Đang bảo trì</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="status-badge status-maintenance">Đang bảo trì</span>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-primary" onclick="editBoat(4)">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteBoat(4, 'GH004')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="boat-card">
                        <div class="boat-header">
                            <h5 class="mb-1">GH005</h5>
                            <p class="mb-0">Ghe Cù Lao Mây 1</p>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <small class="text-muted">Loại ghe</small>
                                    <p class="mb-0"><strong>Ghe khách</strong></p>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Sức chứa</small>
                                    <p class="mb-0"><strong>60 chỗ</strong></p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted">Mô tả</small>
                                <p class="mb-0">Ghe lớn phục vụ tuyến dài</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="status-badge status-active">Đang hoạt động</span>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-primary" onclick="editBoat(5)">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteBoat(5, 'GH005')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Boat Modal -->
    <div class="modal fade" id="addBoatModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle me-2"></i>Thêm ghe mới
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="admin.php?action=add_boat">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Mã ghe <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="boat_code" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tên ghe <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="boat_name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Loại ghe <span class="text-danger">*</span></label>
                                    <select class="form-select" name="boat_type" required>
                                        <option value="">Chọn loại ghe</option>
                                        <option value="Ghe khách">Ghe khách</option>
                                        <option value="Ghe hàng">Ghe hàng</option>
                                        <option value="Ghe du lịch">Ghe du lịch</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Sức chứa <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="capacity" min="1" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô tả</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Trạng thái</label>
                            <select class="form-select" name="status">
                                <option value="active">Đang hoạt động</option>
                                <option value="maintenance">Đang bảo trì</option>
                                <option value="inactive">Không hoạt động</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Thêm ghe</button>
                    </div>
                </form>
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
                    <p>Bạn có chắc chắn muốn xóa ghe <strong id="boatCode"></strong>?</p>
                    <p class="text-muted small">Hành động này không thể hoàn tác.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <form method="POST" action="admin.php?action=delete_boat" style="display: inline;">
                        <input type="hidden" name="boat_id" id="boatId">
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

        // Edit boat
        function editBoat(boatId) {
            window.location.href = `admin.php?action=edit_boat&id=${boatId}`;
        }

        // Delete boat confirmation
        function deleteBoat(boatId, boatCode) {
            document.getElementById('boatId').value = boatId;
            document.getElementById('boatCode').textContent = boatCode;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }
    </script>
</body>
</html> 