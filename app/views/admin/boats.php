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
                <a class="nav-link" href="index.php?controller=admin&action=customers">
                    <i class="bi bi-people"></i>Khách hàng
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="index.php?controller=admin&action=boats">
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
                            <h1 class="mb-1">Quản lý Ghe</h1>
                            <p class="mb-0 text-muted">Quản lý thông tin ghe và trạng thái hoạt động</p>
                        </div>
                        <div>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBoatModal">
                                <i class="bi bi-plus-circle me-2"></i>Thêm ghe mới
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tìm kiếm và lọc -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="searchInput" class="form-label">Tìm kiếm ghe</label>
                                <input type="text" class="form-control" id="searchInput" placeholder="Nhập mã ghe, tên ghe...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="statusFilter" class="form-label">Trạng thái</label>
                                <select class="form-select" id="statusFilter">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="active">Đang hoạt động</option>
                                    <option value="maintenance">Đang bảo trì</option>
                                    <option value="inactive">Không hoạt động</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="typeFilter" class="form-label">Loại ghe</label>
                                <select class="form-select" id="typeFilter">
                                    <option value="">Tất cả loại</option>
                                    <option value="Ghe khách">Ghe khách</option>
                                    <option value="Ghe hàng">Ghe hàng</option>
                                    <option value="Ghe du lịch">Ghe du lịch</option>
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

            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="card-icon primary">
                                    <i class="bi bi-water"></i>
                                </div>
                            </div>
                            <div>
                                <div class="card-title">Tổng số ghe</div>
                                <div class="card-value">5</div>
                                <div class="card-change">Tất cả ghe trong hệ thống</div>
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
                                <div class="card-title">Đang hoạt động</div>
                                <div class="card-value">4</div>
                                <div class="card-change">Ghe đang phục vụ</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="card-icon warning">
                                    <i class="bi bi-tools"></i>
                                </div>
                            </div>
                            <div>
                                <div class="card-title">Đang bảo trì</div>
                                <div class="card-value">1</div>
                                <div class="card-change">Ghe đang bảo trì</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="card-icon danger">
                                    <i class="bi bi-x-circle"></i>
                                </div>
                            </div>
                            <div>
                                <div class="card-title">Không hoạt động</div>
                                <div class="card-value">0</div>
                                <div class="card-change">Ghe tạm ngưng</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boats Table -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Danh sách ghe</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Mã ghe</th>
                                    <th>Tên ghe</th>
                                    <th>Loại ghe</th>
                                    <th>Sức chứa</th>
                                    <th>Mô tả</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>GH001</strong></td>
                                    <td>Ghe Ninh Kiều 1</td>
                                    <td>Ghe khách</td>
                                    <td>50 chỗ</td>
                                    <td>Ghe khách hiện đại, có điều hòa</td>
                                    <td><span class="badge bg-success">Đang hoạt động</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" onclick="editBoat(1)">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteBoat(1, 'GH001')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>GH002</strong></td>
                                    <td>Ghe Cái Răng 1</td>
                                    <td>Ghe khách</td>
                                    <td>40 chỗ</td>
                                    <td>Ghe khách phục vụ tuyến Cái Răng</td>
                                    <td><span class="badge bg-success">Đang hoạt động</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" onclick="editBoat(2)">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteBoat(2, 'GH002')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>GH003</strong></td>
                                    <td>Ghe An Bình 1</td>
                                    <td>Ghe khách</td>
                                    <td>35 chỗ</td>
                                    <td>Ghe khách phục vụ tuyến An Bình</td>
                                    <td><span class="badge bg-success">Đang hoạt động</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" onclick="editBoat(3)">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteBoat(3, 'GH003')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>GH004</strong></td>
                                    <td>Ghe Phong Điền 1</td>
                                    <td>Ghe khách</td>
                                    <td>45 chỗ</td>
                                    <td>Đang bảo trì</td>
                                    <td><span class="badge bg-warning">Đang bảo trì</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" onclick="editBoat(4)">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteBoat(4, 'GH004')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>GH005</strong></td>
                                    <td>Ghe Cù Lao Mây 1</td>
                                    <td>Ghe khách</td>
                                    <td>60 chỗ</td>
                                    <td>Ghe lớn phục vụ tuyến dài</td>
                                    <td><span class="badge bg-success">Đang hoạt động</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" onclick="editBoat(5)">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteBoat(5, 'GH005')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Add Boat Modal -->
    <div class="modal fade" id="addBoatModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm ghe mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="index.php?controller=admin&action=add_boat">
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
                    <h5 class="modal-title">Xác nhận xóa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa ghe <strong id="boatCode"></strong>?</p>
                    <p class="text-muted small">Hành động này không thể hoàn tác.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <form method="POST" action="index.php?controller=admin&action=delete_boat" style="display: inline;">
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
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }

        function editBoat(boatId) {
            window.location.href = `index.php?controller=admin&action=edit_boat&id=${boatId}`;
        }

        function deleteBoat(boatId, boatCode) {
            document.getElementById('boatId').value = boatId;
            document.getElementById('boatCode').textContent = boatCode;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }

        // Tìm kiếm ghe
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

        // Lọc theo loại ghe
        document.getElementById('typeFilter').addEventListener('change', function() {
            applyFilters();
        });

        function applyFilters() {
            const statusFilter = document.getElementById('statusFilter').value;
            const typeFilter = document.getElementById('typeFilter').value;
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            
            const tableRows = document.querySelectorAll('tbody tr');
            
            tableRows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const boatType = cells[2].textContent.toLowerCase();
                const status = cells[5].textContent.toLowerCase();
                const text = row.textContent.toLowerCase();
                
                let show = true;
                
                // Lọc theo tìm kiếm
                if (searchTerm && !text.includes(searchTerm)) {
                    show = false;
                }
                
                // Lọc theo trạng thái
                if (statusFilter) {
                    if (statusFilter === 'active' && !status.includes('hoạt động')) show = false;
                    if (statusFilter === 'maintenance' && !status.includes('bảo trì')) show = false;
                    if (statusFilter === 'inactive' && !status.includes('không hoạt động')) show = false;
                }
                
                // Lọc theo loại ghe
                if (typeFilter && boatType !== typeFilter.toLowerCase()) {
                    show = false;
                }
                
                row.style.display = show ? '' : 'none';
            });
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('typeFilter').value = '';
            
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach(row => {
                row.style.display = '';
            });
        }
    </script>
</body>
</html> 