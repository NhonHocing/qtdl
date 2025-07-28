-- Dữ liệu mẫu GheDay - Phù hợp với luồng thực tế

-- 1. Thêm admin mặc định (password: admin123)
INSERT INTO admin_users (username, password, fullname, email, role, status) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Chủ Ghe Ninh Kiều', 'admin@gheday.vn', 'super_admin', 'active'),
('nlcs', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Chủ Ghe Cái Răng', 'nlcs@gheday.vn', 'admin', 'active')
ON CONFLICT (username) DO NOTHING;

-- 2. Thêm khách hàng thực tế với SĐT (password: 123456)
INSERT INTO users (username, password, fullname, email, address, phone) VALUES 
('nguyenvana', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Nguyễn Văn An', 'nguyenvana@gmail.com', '123 Đường 3/2, Quận Ninh Kiều, Cần Thơ', '0901234567'),
('tranthib', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Trần Thị Bình', 'tranthib@gmail.com', '456 Đường Nguyễn Văn Linh, Quận Bình Thủy, Cần Thơ', '0912345678'),
('levanc', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Lê Văn Cường', 'levanc@gmail.com', '789 Đường 30/4, Quận Cái Răng, Cần Thơ', '0923456789'),
('phamthid', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Phạm Thị Dung', 'phamthid@gmail.com', '321 Đường Lý Tự Trọng, Quận Ninh Kiều, Cần Thơ', '0934567890'),
('hoangvane', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Hoàng Văn Em', 'hoangvane@gmail.com', '654 Đường Trần Hưng Đạo, Quận Cái Răng, Cần Thơ', '0945678901'),
('nguyenthif', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Nguyễn Thị Phương', 'nguyenthif@gmail.com', '987 Đường Nguyễn Trãi, Quận Bình Thủy, Cần Thơ', '0956789012'),
('tranvang', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Trần Văn Giang', 'tranvang@gmail.com', '147 Đường Lê Lợi, Quận Ninh Kiều, Cần Thơ', '0967890123'),
('levanhh', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Lê Văn Hùng', 'levanhh@gmail.com', '258 Đường Võ Văn Tần, Quận Cái Răng, Cần Thơ', '0978901234'),
('phamthii', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Phạm Thị Lan', 'phamthii@gmail.com', '369 Đường Nguyễn Huệ, Quận Bình Thủy, Cần Thơ', '0989012345'),
('nguyenvanj', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Nguyễn Văn Khoa', 'nguyenvanj@gmail.com', '741 Đường Trần Phú, Quận Ninh Kiều, Cần Thơ', '0990123456')
ON CONFLICT (username) DO NOTHING;

-- 3. Thêm ghe thực tế của Cần Thơ
INSERT INTO boats (boat_code, boat_name, boat_type, capacity, status, description) VALUES 
('GH001', 'Ghe Ninh Kiều 1', 'Ghe khách', 50, 'active', 'Ghe khách hiện đại, có điều hòa, phục vụ tuyến Ninh Kiều - Cái Răng'),
('GH002', 'Ghe Cái Răng 1', 'Ghe khách', 40, 'active', 'Ghe khách phục vụ tuyến An Bình - Cái Răng'),
('GH003', 'Ghe Cù Lao Mây', 'Ghe khách', 60, 'active', 'Ghe khách lớn, phục vụ tuyến Ninh Kiều - Cù Lao Mây'),
('GH004', 'Ghe Phong Điền', 'Ghe khách', 35, 'active', 'Ghe khách phục vụ tuyến Cái Răng - Phong Điền'),
('GH005', 'Ghe An Bình 2', 'Ghe khách', 45, 'active', 'Ghe khách phục vụ tuyến An Bình - Cái Răng')
ON CONFLICT (boat_code) DO NOTHING;

-- 4. Thêm tuyến đường thực tế của Cần Thơ
INSERT INTO routes (route_code, route_name, departure_point, arrival_point, duration, adult_price, child_price, status) VALUES 
('RT001', 'Bến Ninh Kiều → Chợ nổi Cái Răng', 'Bến Ninh Kiều', 'Chợ nổi Cái Răng', 90, 150000.00, 75000.00, 'active'),
('RT002', 'Chợ An Bình → Chợ nổi Cái Răng', 'Chợ An Bình', 'Chợ nổi Cái Răng', 60, 100000.00, 50000.00, 'active'),
('RT003', 'Bến Ninh Kiều → Cù Lao Mây', 'Bến Ninh Kiều', 'Cù Lao Mây', 240, 300000.00, 150000.00, 'active'),
('RT004', 'Chợ nổi Cái Răng → Phong Điền', 'Chợ nổi Cái Răng', 'Phong Điền', 120, 200000.00, 100000.00, 'active')
ON CONFLICT (route_code) DO NOTHING;

-- 5. Thêm chuyến đi thực tế
INSERT INTO trips (trip_code, boat_id, route_id, departure_time, arrival_time, total_seats, booked_seats, available_seats, status) VALUES 
('TR001', 1, 1, '2025-01-15 08:00:00', '2025-01-15 09:30:00', 50, 25, 25, 'scheduled'),
('TR002', 2, 2, '2025-01-15 10:00:00', '2025-01-15 11:00:00', 40, 15, 25, 'scheduled'),
('TR003', 3, 3, '2025-01-16 06:00:00', '2025-01-16 10:00:00', 60, 30, 30, 'scheduled'),
('TR004', 4, 4, '2025-01-17 13:00:00', '2025-01-17 15:00:00', 35, 20, 15, 'scheduled')
ON CONFLICT (trip_code) DO NOTHING;

-- 6. Thêm booking thực tế với trạng thái pending để admin gọi điện xác nhận
INSERT INTO bookings (user_id, route, departure_date, departure_time, adult_tickets, child_tickets, adult_price, child_price, total_price, passenger_name, phone, email, special_requests, status) VALUES 
-- Booking đã xác nhận (confirmed) - Chủ ghe đã gọi điện xác nhận
(1, 'ninh_kieu_cai_rang', '2025-01-15', '08:00:00', 2, 1, 300000, 75000, 375000, 'Nguyễn Văn An', '0901234567', 'nguyenvana@gmail.com', 'Cần ghế gần cửa sổ', 'confirmed'),
(2, 'an_binh_cai_rang', '2025-01-15', '10:00:00', 1, 0, 100000, 0, 100000, 'Trần Thị Bình', '0912345678', 'tranthib@gmail.com', 'Không có yêu cầu đặc biệt', 'confirmed'),
(3, 'ninh_kieu_cu_lao_may', '2025-01-16', '06:00:00', 3, 2, 900000, 300000, 1200000, 'Lê Văn Cường', '0923456789', 'levanc@gmail.com', 'Cần ghế gia đình', 'confirmed'),

-- Booking chờ xác nhận (pending) - Chủ ghe cần gọi điện xác nhận
(4, 'ninh_kieu_cai_rang', '2025-01-18', '08:00:00', 1, 1, 150000, 75000, 225000, 'Phạm Thị Dung', '0934567890', 'phamthid@gmail.com', 'Cần ghế gần cửa sổ', 'pending'),
(5, 'an_binh_cai_rang', '2025-01-19', '10:00:00', 2, 0, 200000, 0, 200000, 'Hoàng Văn Em', '0945678901', 'hoangvane@gmail.com', 'Không có yêu cầu đặc biệt', 'pending'),
(6, 'cai_rang_phong_dien', '2025-01-20', '13:00:00', 1, 1, 200000, 100000, 300000, 'Nguyễn Thị Phương', '0956789012', 'nguyenthif@gmail.com', 'Cần ghế gần cửa sổ', 'pending'),
(7, 'ninh_kieu_cu_lao_may', '2025-01-21', '06:00:00', 2, 1, 600000, 150000, 750000, 'Trần Văn Giang', '0967890123', 'tranvang@gmail.com', 'Cần ghế gia đình', 'pending'),
(8, 'ninh_kieu_cai_rang', '2025-01-22', '08:00:00', 3, 0, 450000, 0, 450000, 'Lê Văn Hùng', '0978901234', 'levanhh@gmail.com', 'Cần ghế gần cửa sổ', 'pending'),
(9, 'an_binh_cai_rang', '2025-01-23', '10:00:00', 1, 2, 100000, 100000, 200000, 'Phạm Thị Lan', '0989012345', 'phamthii@gmail.com', 'Cần ghế gia đình', 'pending'),
(10, 'cai_rang_phong_dien', '2025-01-24', '13:00:00', 2, 1, 400000, 100000, 500000, 'Nguyễn Văn Khoa', '0990123456', 'nguyenvanj@gmail.com', 'Không có yêu cầu đặc biệt', 'pending'),

-- Booking đã hoàn thành (completed)
(1, 'cai_rang_phong_dien', '2025-01-10', '13:00:00', 1, 1, 200000, 100000, 300000, 'Nguyễn Văn An', '0901234567', 'nguyenvana@gmail.com', 'Cần ghế gần cửa sổ', 'completed'),
(2, 'ninh_kieu_cu_lao_may', '2025-01-12', '06:00:00', 2, 1, 600000, 150000, 750000, 'Trần Thị Bình', '0912345678', 'tranthib@gmail.com', 'Cần ghế gia đình', 'completed'),

-- Booking đã hủy (cancelled)
(3, 'ninh_kieu_cai_rang', '2025-01-25', '08:00:00', 2, 0, 300000, 0, 300000, 'Lê Văn Cường', '0923456789', 'levanc@gmail.com', 'Đã hủy', 'cancelled'),
(4, 'an_binh_cai_rang', '2025-01-26', '10:00:00', 1, 0, 100000, 0, 100000, 'Phạm Thị Dung', '0934567890', 'phamthid@gmail.com', 'Đã hủy', 'cancelled')
ON CONFLICT DO NOTHING;

-- 7. Thêm dịch vụ thực tế
INSERT INTO services (service_code, service_name, service_type, description, price, status) VALUES 
('SV001', 'Bữa sáng', 'Ăn uống', 'Bữa sáng đầy đủ với phở, bánh mì', 50000.00, 'active'),
('SV002', 'Hướng dẫn viên', 'Tour', 'Hướng dẫn viên địa phương', 100000.00, 'active'),
('SV003', 'Bảo hiểm du lịch', 'Bảo hiểm', 'Bảo hiểm du lịch cho chuyến đi', 30000.00, 'active'),
('SV004', 'Chụp ảnh', 'Dịch vụ', 'Chụp ảnh kỷ niệm tại chợ nổi', 50000.00, 'active')
ON CONFLICT (service_code) DO NOTHING;

-- 8. Thêm cấu hình hệ thống thực tế
INSERT INTO system_configs (config_key, config_value, config_type, description) VALUES 
('system_name', 'GheDay - Hệ thống đặt vé tàu chợ nổi Cần Thơ', 'string', 'Tên hệ thống'),
('company_address', 'Bến Ninh Kiều, Quận Ninh Kiều, TP. Cần Thơ', 'string', 'Địa chỉ công ty'),
('company_phone', '0292 3 888 999', 'string', 'Số điện thoại công ty'),
('company_email', 'info@gheday.vn', 'string', 'Email công ty'),
('booking_notice', 'Sau khi đặt vé, chúng tôi sẽ liên hệ qua điện thoại để xác nhận trong vòng 2 giờ', 'string', 'Thông báo đặt vé'),
('cancellation_policy', 'Có thể hủy vé trước 6 giờ so với giờ khởi hành', 'string', 'Chính sách hủy vé')
ON CONFLICT (config_key) DO NOTHING;

-- 9. Thêm thông báo thực tế
INSERT INTO notifications (title, content, type, target_audience, status, start_date, end_date, created_by) VALUES 
('Chào mừng đến với GheDay!', 'Hệ thống đặt vé tàu chợ nổi Cần Thơ chính thức hoạt động. Sau khi đặt vé, chúng tôi sẽ liên hệ qua điện thoại để xác nhận.', 'info', 'all', 'active', '2025-01-01 00:00:00', '2025-12-31 23:59:59', 1),
('Lưu ý đặt vé', 'Vui lòng cung cấp số điện thoại chính xác để chúng tôi có thể liên hệ xác nhận vé.', 'warning', 'all', 'active', '2025-01-01 00:00:00', '2025-12-31 23:59:59', 1),
('Chính sách hủy vé', 'Có thể hủy vé trước 6 giờ so với giờ khởi hành. Liên hệ hotline để được hỗ trợ.', 'info', 'all', 'active', '2025-01-01 00:00:00', '2025-12-31 23:59:59', 1)
ON CONFLICT DO NOTHING;

-- Xong
SELECT 'Dữ liệu mẫu thực tế đã import xong! Chủ ghe có thể gọi điện xác nhận các booking pending.' as status; 