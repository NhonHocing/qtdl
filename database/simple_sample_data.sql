-- Dữ liệu mẫu GheDay

-- 1. Thêm admin mặc định (password: admin123)
INSERT INTO admin_users (username, password, fullname, email, role, status) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin@gheday.vn', 'super_admin', 'active')
ON CONFLICT (username) DO NOTHING;

-- 2. Thêm user mẫu (password: 123456)
INSERT INTO users (username, password, fullname, email, address, phone) VALUES 
('testuser', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Nguyễn Văn Test', 'test@example.com', '123 Đường ABC, Quận 1, TP.HCM', '0123456789')
ON CONFLICT (username) DO NOTHING;

-- 3. Thêm ghe mẫu
INSERT INTO boats (boat_code, boat_name, boat_type, capacity, status, description) VALUES 
('GH001', 'Ghe Ninh Kiều 1', 'Ghe khách', 50, 'active', 'Ghe khách hiện đại, có điều hòa'),
('GH002', 'Ghe Cái Răng 1', 'Ghe khách', 40, 'active', 'Ghe khách phục vụ tuyến Cái Răng')
ON CONFLICT (boat_code) DO NOTHING;

-- 4. Thêm tuyến đường mẫu
INSERT INTO routes (route_code, route_name, departure_point, arrival_point, duration, adult_price, child_price, status) VALUES 
('RT001', 'Bến Ninh Kiều → Chợ nổi Cái Răng', 'Bến Ninh Kiều', 'Chợ nổi Cái Răng', 90, 150000.00, 75000.00, 'active'),
('RT002', 'Chợ An Bình → Chợ nổi Cái Răng', 'Chợ An Bình', 'Chợ nổi Cái Răng', 60, 100000.00, 50000.00, 'active')
ON CONFLICT (route_code) DO NOTHING;

-- 5. Thêm chuyến đi mẫu
INSERT INTO trips (trip_code, boat_id, route_id, departure_time, arrival_time, total_seats, booked_seats, available_seats, status) VALUES 
('TR001', 1, 1, '2025-01-15 08:00:00', '2025-01-15 09:30:00', 50, 25, 25, 'scheduled'),
('TR002', 2, 2, '2025-01-15 10:00:00', '2025-01-15 11:00:00', 40, 15, 25, 'scheduled')
ON CONFLICT (trip_code) DO NOTHING;

-- 6. Thêm booking mẫu
INSERT INTO bookings (user_id, route, departure_date, departure_time, adult_tickets, child_tickets, adult_price, child_price, total_price, passenger_name, phone, email, special_requests, status) VALUES 
(1, 'ninh_kieu_cai_rang', '2025-01-15', '08:00:00', 2, 1, 300000, 75000, 375000, 'Nguyễn Văn Test', '0123456789', 'test@example.com', 'Cần ghế gần cửa sổ', 'confirmed')
ON CONFLICT DO NOTHING;

-- 7. Thêm dịch vụ mẫu
INSERT INTO services (service_code, service_name, service_type, description, price, status) VALUES 
('SV001', 'Bữa sáng', 'Ăn uống', 'Bữa sáng đầy đủ với phở, bánh mì', 50000.00, 'active'),
('SV002', 'Hướng dẫn viên', 'Tour', 'Hướng dẫn viên địa phương', 100000.00, 'active')
ON CONFLICT (service_code) DO NOTHING;

-- 8. Thêm cấu hình hệ thống
INSERT INTO system_configs (config_key, config_value, config_type, description) VALUES 
('system_name', 'GheDay - Hệ thống đặt vé tàu chợ nổi', 'string', 'Tên hệ thống'),
('company_address', '231-233 Lê Hồng Phong, Phường 4, Quận 5, TP. Hồ Chí Minh', 'string', 'Địa chỉ công ty'),
('company_phone', '1900 6067', 'string', 'Số điện thoại công ty'),
('company_email', 'support@gheday.vn', 'string', 'Email công ty')
ON CONFLICT (config_key) DO NOTHING;

-- 9. Thêm thông báo mẫu
INSERT INTO notifications (title, content, type, target_audience, status, start_date, end_date, created_by) VALUES 
('Chào mừng đến với GheDay!', 'Hệ thống đặt vé tàu chợ nổi Cần Thơ chính thức hoạt động.', 'info', 'all', 'active', '2025-01-01 00:00:00', '2025-12-31 23:59:59', 1)
ON CONFLICT DO NOTHING;

-- Xong
SELECT 'Dữ liệu mẫu đã import xong!' as status; 