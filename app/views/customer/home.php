<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gheday - Đặt vé tàu du lịch Miền Sông Nước</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/home.css">
    <link rel="icon" href="img/logo_gheday.png" type="image/png">
</head>
<body>
<?php include __DIR__ . '/../layouts/header.php'; ?>

    <!-- Main Content -->
    <main style="margin-top: 76px;">
        <!-- Hero Section với Tìm kiếm ghe -->
        <section class="hero-section">
            <div class="container">
                <div class="hero-content">
                    <h1 class="hero-title">Đặt vé tàu du lịch tại chợ nổi Cái Răng</h1>
                    <p class="hero-subtitle">Để có thể khám phá du lịch Miền Sông nước</p>
                    
                    <!-- Tìm kiếm ghe trong Hero -->
                    <div class="search-form-hero mt-4">
                        <div class="row g-3 justify-content-center">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="searchBoatType" class="form-label text-white">
                                        <i class="bi bi-search me-2"></i>Loại ghe
                                    </label>
                                    <select class="form-select" id="searchBoatType">
                                        <option value="">Tất cả</option>
                                        <option value="5">Ghe 5 chỗ</option>
                                        <option value="15">Ghe 15 chỗ</option>
                                        <option value="30">Ghe 30 chỗ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="searchRoute" class="form-label text-white">
                                        <i class="bi bi-geo-alt me-2"></i>Tuyến đường
                                    </label>
                                    <select class="form-select" id="searchRoute">
                                        <option value="">Tất cả tuyến</option>
                                        <option value="ninh_kieu_cai_rang">Bến Ninh Kiều → Chợ nổi Cái Răng</option>
                                        <option value="an_binh_cai_rang">Chợ An Bình → Chợ nổi Cái Răng</option>
                                        <option value="ninh_kieu_cu_lao_may">Bến Ninh Kiều → Cù Lao Mây</option>
                                        <option value="cai_rang_phong_dien">Chợ nổi Cái Răng → Phong Điền</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="searchTime" class="form-label text-white">
                                        <i class="bi bi-clock me-2"></i>Giờ đi
                                    </label>
                                    <select class="form-select" id="searchTime">
                                        <option value="">Tất cả</option>
                                        <option value="06:00">06:00</option>
                                        <option value="08:00">08:00</option>
                                        <option value="09:30">09:30</option>
                                        <option value="10:00">10:00</option>
                                        <option value="11:00">11:00</option>
                                        <option value="13:00">13:00</option>
                                        <option value="14:00">14:00</option>
                                        <option value="15:30">15:30</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-grid">
                                        <button class="btn btn-light btn-lg" onclick="searchBoats()">
                                            <i class="bi bi-search me-1"></i>Tìm ghe
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kết quả tìm kiếm trong Hero -->
                    <div id="searchResults" class="mt-4" style="display: none;">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Kết quả tìm kiếm</h5>
                            </div>
                            <div class="card-body">
                                <div id="resultsList" class="row g-3">
                                    <!-- Kết quả sẽ hiển thị ở đây -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Popular Routes Section -->
        <section class="routes-section">
            <div class="container">
                <h2 class="section-title">TUYẾN PHỔ BIẾN</h2>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="route-card">
                            <img src="img/bến - chợ.jpg" alt="Bến Ninh Kiều - Chợ nổi Cái Răng" class="card-img-top">
                            <div class="route-card-body">
                                <h3 class="route-card-title">Bến Ninh Kiều - Chợ nổi Cái Răng</h3>
                                <p class="route-card-text">
                                    <i class="bi bi-clock me-1"></i>Thời gian: 1 giờ 30 phút<br>
                                    <i class="bi bi-currency-dollar me-1"></i>Giá từ: 150.000 VNĐ
                                </p>
                                <a href="index.php?controller=customer&action=booking&route=ninh_kieu_cai_rang" class="btn btn-route">
                                    <i class="bi bi-ticket-perforated me-1"></i>Đặt Vé
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6">
                        <div class="route-card">
                            <img src="img/chợ ab - chợ nổi.jpg" alt="Chợ An Bình - Chợ nổi Cái Răng" class="card-img-top">
                            <div class="route-card-body">
                                <h3 class="route-card-title">Chợ An Bình - Chợ nổi Cái Răng</h3>
                                <p class="route-card-text">
                                    <i class="bi bi-clock me-1"></i>Thời gian: 1 giờ<br>
                                    <i class="bi bi-currency-dollar me-1"></i>Giá từ: 100.000 VNĐ
                                </p>
                                <a href="index.php?controller=customer&action=booking&route=an_binh_cai_rang" class="btn btn-route">
                                    <i class="bi bi-ticket-perforated me-1"></i>Đặt Vé
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6">
                        <div class="route-card">
                            <img src="img/bến - cù lao mây.jpg" alt="Bến Ninh Kiều - Cù Lao Mây" class="card-img-top">
                            <div class="route-card-body">
                                <h3 class="route-card-title">Bến Ninh Kiều - Cù Lao Mây</h3>
                                <p class="route-card-text">
                                    <i class="bi bi-clock me-1"></i>Thời gian: 4 giờ<br>
                                    <i class="bi bi-currency-dollar me-1"></i>Giá từ: 300.000 VNĐ
                                </p>
                                <a href="index.php?controller=customer&action=booking&route=ninh_kieu_cu_lao_may" class="btn btn-route">
                                    <i class="bi bi-ticket-perforated me-1"></i>Đặt Vé
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6">
                        <div class="route-card">
                            <img src="img/cau_cai_rang.jpg" alt="Chợ nổi Cái Răng - Phong Điền" class="card-img-top">
                            <div class="route-card-body">
                                <h3 class="route-card-title">Chợ nổi Cái Răng - Phong Điền</h3>
                                <p class="route-card-text">
                                    <i class="bi bi-clock me-1"></i>Thời gian: 2 giờ<br>
                                    <i class="bi bi-currency-dollar me-1"></i>Giá từ: 200.000 VNĐ
                                </p>
                                <a href="index.php?controller=customer&action=booking&route=cai_rang_phong_dien" class="btn btn-route">
                                    <i class="bi bi-ticket-perforated me-1"></i>Đặt Vé
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Dữ liệu ghe mẫu
        const boatsData = [
            // Tuyến Ninh Kiều → Cái Răng (08:00)
            {
                id: 1,
                code: 'GH001',
                type: 'Ghe 30 chỗ',
                capacity: 30,
                status: 'Đang hoạt động',
                description: 'Ghe khách hiện đại, có điều hòa',
                routes: ['ninh_kieu_cai_rang'],
                departureTime: '08:00'
            },
            {
                id: 2,
                code: 'GH002',
                type: 'Ghe 15 chỗ',
                capacity: 15,
                status: 'Đang hoạt động',
                description: 'Ghe vừa phục vụ tuyến ngắn',
                routes: ['ninh_kieu_cai_rang'],
                departureTime: '08:00'
            },
            {
                id: 3,
                code: 'GH003',
                type: 'Ghe 5 chỗ',
                capacity: 5,
                status: 'Đang hoạt động',
                description: 'Ghe nhỏ phục vụ gia đình',
                routes: ['ninh_kieu_cai_rang'],
                departureTime: '08:00'
            },

            // Tuyến An Bình → Cái Răng (10:00)
            {
                id: 4,
                code: 'GH004',
                type: 'Ghe 30 chỗ',
                capacity: 30,
                status: 'Đang hoạt động',
                description: 'Ghe lớn phục vụ tuyến Cái Răng',
                routes: ['an_binh_cai_rang'],
                departureTime: '10:00'
            },
            {
                id: 5,
                code: 'GH005',
                type: 'Ghe 15 chỗ',
                capacity: 15,
                status: 'Đang hoạt động',
                description: 'Ghe vừa phục vụ tuyến Cái Răng',
                routes: ['an_binh_cai_rang'],
                departureTime: '10:00'
            },
            {
                id: 6,
                code: 'GH006',
                type: 'Ghe 5 chỗ',
                capacity: 5,
                status: 'Đang hoạt động',
                description: 'Ghe nhỏ phục vụ gia đình',
                routes: ['an_binh_cai_rang'],
                departureTime: '10:00'
            },

            // Tuyến Ninh Kiều → Cù Lao Mây (06:00)
            {
                id: 7,
                code: 'GH007',
                type: 'Ghe 30 chỗ',
                capacity: 30,
                status: 'Đang hoạt động',
                description: 'Ghe lớn phục vụ tuyến dài',
                routes: ['ninh_kieu_cu_lao_may'],
                departureTime: '06:00'
            },
            {
                id: 8,
                code: 'GH008',
                type: 'Ghe 15 chỗ',
                capacity: 15,
                status: 'Đang hoạt động',
                description: 'Ghe vừa phục vụ tuyến dài',
                routes: ['ninh_kieu_cu_lao_may'],
                departureTime: '06:00'
            },
            {
                id: 9,
                code: 'GH009',
                type: 'Ghe 5 chỗ',
                capacity: 5,
                status: 'Đang hoạt động',
                description: 'Ghe nhỏ phục vụ gia đình',
                routes: ['ninh_kieu_cu_lao_may'],
                departureTime: '06:00'
            },

            // Tuyến Cái Răng → Phong Điền (13:00)
            {
                id: 10,
                code: 'GH010',
                type: 'Ghe 30 chỗ',
                capacity: 30,
                status: 'Đang hoạt động',
                description: 'Ghe lớn phục vụ tuyến Phong Điền',
                routes: ['cai_rang_phong_dien'],
                departureTime: '13:00'
            },
            {
                id: 11,
                code: 'GH011',
                type: 'Ghe 15 chỗ',
                capacity: 15,
                status: 'Đang hoạt động',
                description: 'Ghe vừa phục vụ tuyến Phong Điền',
                routes: ['cai_rang_phong_dien'],
                departureTime: '13:00'
            },
            {
                id: 12,
                code: 'GH012',
                type: 'Ghe 5 chỗ',
                capacity: 5,
                status: 'Đang hoạt động',
                description: 'Ghe nhỏ phục vụ gia đình',
                routes: ['cai_rang_phong_dien'],
                departureTime: '13:00'
            },

            // Tuyến Ninh Kiều → Cái Răng (11:00)
            {
                id: 13,
                code: 'GH013',
                type: 'Ghe 30 chỗ',
                capacity: 30,
                status: 'Đang hoạt động',
                description: 'Ghe khách hiện đại, có điều hòa',
                routes: ['ninh_kieu_cai_rang'],
                departureTime: '11:00'
            },
            {
                id: 14,
                code: 'GH014',
                type: 'Ghe 15 chỗ',
                capacity: 15,
                status: 'Đang hoạt động',
                description: 'Ghe vừa phục vụ tuyến ngắn',
                routes: ['ninh_kieu_cai_rang'],
                departureTime: '11:00'
            },
            {
                id: 15,
                code: 'GH015',
                type: 'Ghe 5 chỗ',
                capacity: 5,
                status: 'Đang hoạt động',
                description: 'Ghe nhỏ phục vụ gia đình',
                routes: ['ninh_kieu_cai_rang'],
                departureTime: '11:00'
            },

            // Tuyến An Bình → Cái Răng (09:30)
            {
                id: 16,
                code: 'GH016',
                type: 'Ghe 30 chỗ',
                capacity: 30,
                status: 'Đang hoạt động',
                description: 'Ghe lớn phục vụ tuyến Cái Răng',
                routes: ['an_binh_cai_rang'],
                departureTime: '09:30'
            },
            {
                id: 17,
                code: 'GH017',
                type: 'Ghe 15 chỗ',
                capacity: 15,
                status: 'Đang hoạt động',
                description: 'Ghe vừa phục vụ tuyến Cái Răng',
                routes: ['an_binh_cai_rang'],
                departureTime: '09:30'
            },
            {
                id: 18,
                code: 'GH018',
                type: 'Ghe 5 chỗ',
                capacity: 5,
                status: 'Đang hoạt động',
                description: 'Ghe nhỏ phục vụ gia đình',
                routes: ['an_binh_cai_rang'],
                departureTime: '09:30'
            },

            // Tuyến Cái Răng → Phong Điền (14:00)
            {
                id: 19,
                code: 'GH019',
                type: 'Ghe 30 chỗ',
                capacity: 30,
                status: 'Đang bảo trì',
                description: 'Đang bảo trì',
                routes: ['cai_rang_phong_dien'],
                departureTime: '14:00'
            },
            {
                id: 20,
                code: 'GH020',
                type: 'Ghe 15 chỗ',
                capacity: 15,
                status: 'Đang hoạt động',
                description: 'Ghe vừa phục vụ tuyến Phong Điền',
                routes: ['cai_rang_phong_dien'],
                departureTime: '14:00'
            },
            {
                id: 21,
                code: 'GH021',
                type: 'Ghe 5 chỗ',
                capacity: 5,
                status: 'Đang hoạt động',
                description: 'Ghe nhỏ phục vụ gia đình',
                routes: ['cai_rang_phong_dien'],
                departureTime: '14:00'
            },

            // Tuyến An Bình → Cái Răng (15:30)
            {
                id: 22,
                code: 'GH022',
                type: 'Ghe 30 chỗ',
                capacity: 30,
                status: 'Đang hoạt động',
                description: 'Ghe lớn phục vụ tuyến Cái Răng',
                routes: ['an_binh_cai_rang'],
                departureTime: '15:30'
            },
            {
                id: 23,
                code: 'GH023',
                type: 'Ghe 15 chỗ',
                capacity: 15,
                status: 'Đang hoạt động',
                description: 'Ghe vừa phục vụ tuyến Cái Răng',
                routes: ['an_binh_cai_rang'],
                departureTime: '15:30'
            },
            {
                id: 24,
                code: 'GH024',
                type: 'Ghe 5 chỗ',
                capacity: 5,
                status: 'Đang hoạt động',
                description: 'Ghe nhỏ phục vụ gia đình',
                routes: ['an_binh_cai_rang'],
                departureTime: '15:30'
            }
        ];

        // Tìm kiếm ghe
        function searchBoats() {
            const selectedRoute = document.getElementById('searchRoute').value;
            const selectedBoatType = document.getElementById('searchBoatType').value;
            const selectedTime = document.getElementById('searchTime').value;
            
            // Lọc ghe theo điều kiện
            const filteredBoats = boatsData.filter(boat => {
                let match = true;
                
                // Lọc theo tuyến đường
                if (selectedRoute && !boat.routes.includes(selectedRoute)) {
                    match = false;
                }
                
                // Lọc theo loại ghe
                if (selectedBoatType && boat.capacity != parseInt(selectedBoatType)) {
                    match = false;
                }
                
                // Lọc theo thời gian
                if (selectedTime && boat.departureTime !== selectedTime) {
                    match = false;
                }
                
                return match;
            });
            
            // Hiển thị kết quả
            displaySearchResults(filteredBoats);
        }

        // Hiển thị kết quả tìm kiếm
        function displaySearchResults(boats) {
            const resultsContainer = document.getElementById('searchResults');
            const resultsList = document.getElementById('resultsList');
            
            if (boats.length === 0) {
                resultsList.innerHTML = `
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <i class="bi bi-info-circle me-2"></i>
                            Không tìm thấy ghe nào phù hợp với điều kiện tìm kiếm.
                        </div>
                    </div>
                `;
            } else {
                resultsList.innerHTML = boats.map(boat => `
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title mb-0">${boat.code}</h5>
                                    <span class="badge ${getStatusBadgeClass(boat.status)}">${boat.status}</span>
                                </div>
                                <h6 class="card-subtitle mb-2 text-muted">${boat.type}</h6>
                                <p class="card-text small">
                                    <strong>Loại:</strong> <span class="text-primary fw-bold">${boat.type}</span><br>
                                    <strong>Giờ khởi hành:</strong> <span class="text-success">${boat.departureTime}</span><br>
                                    <strong>Mô tả:</strong> ${boat.description}
                                </p>
                                <div class="d-grid">
                                    <a href="index.php?controller=customer&action=booking" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-ticket-perforated me-1"></i>Đặt vé
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                `).join('');
            }
            
            resultsContainer.style.display = 'block';
        }

        // Lấy class cho badge trạng thái
        function getStatusBadgeClass(status) {
            switch (status) {
                case 'Đang hoạt động':
                    return 'bg-success';
                case 'Đang bảo trì':
                    return 'bg-warning text-dark';
                case 'Không hoạt động':
                    return 'bg-danger';
                default:
                    return 'bg-secondary';
            }
        }

        // Tìm kiếm khi thay đổi tuyến đường
        document.getElementById('searchRoute').addEventListener('change', function() {
            searchBoats();
        });

        // Tìm kiếm khi thay đổi loại ghe
        document.getElementById('searchBoatType').addEventListener('change', function() {
            searchBoats();
        });

        // Tìm kiếm khi thay đổi thời gian
        document.getElementById('searchTime').addEventListener('change', function() {
            searchBoats();
        });
    </script>

    <?php include __DIR__ . '/../layouts/footer.php'; ?>
</body>
</html>
