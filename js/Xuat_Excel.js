// DOM Elements
const exportType = document.getElementById('exportType');
const exportBtn = document.getElementById('exportBtn');

// Sample data (replace with actual API calls in production)
let rooms = [
    { id: 'P001', so_phong: '101', ma_loai: 'LP001', trang_thai: 'Trống' },
    { id: 'P002', so_phong: '201', ma_loai: 'LP002', trang_thai: 'Đang sử dụng' },
];

let bookings = [
    { id: 'DP001', ma_khach_hang: 'KH001', ma_phong: 'P001', ngay_den: '2025-07-24', ngay_di: '2025-07-26', trang_thai: 'Đã đặt' },
    { id: 'DP002', ma_khach_hang: 'KH002', ma_phong: 'P002', ngay_den: '2025-07-25', ngay_di: '2025-07-27', trang_thai: 'Đang sử dụng' },
];

let invoices = [
    { id: 'HD001', ma_khach_hang: 'KH001', ma_phong: 'P001', ngay_lap: '2025-07-23', tong_tien: 1000000, trang_thai: 'Chưa thanh toán' },
    { id: 'HD002', ma_khach_hang: 'KH002', ma_phong: 'P002', ngay_lap: '2025-07-24', tong_tien: 1500000, trang_thai: 'Đã thanh toán' },
];

let roomTypes = [
    { id: 'LP001', name: 'Phòng Đơn' },
    { id: 'LP002', name: 'Phòng Đôi' },
];

let customers = [
    { id: 'KH001', name: 'Lê Văn C' },
    { id: 'KH002', name: 'Phạm Thị D' },
];

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    exportBtn.addEventListener('click', exportToExcel);
});

// Export to Excel
function exportToExcel() {
    const type = exportType.value;
    let data = [];
    let worksheetName = '';
    let fileName = '';

    switch (type) {
        case 'rooms':
            data = rooms.map(room => ({
                'Mã phòng': room.id,
                'Số phòng': room.so_phong,
                'Loại phòng': roomTypes.find(rt => rt.id === room.ma_loai).name,
                'Trạng thái': room.trang_thai
            }));
            worksheetName = 'DanhSachPhong';
            fileName = 'DanhSachPhong.xlsx';
            break;

        case 'bookings':
            data = bookings.map(booking => ({
                'Mã đặt phòng': booking.id,
                'Khách hàng': customers.find(c => c.id === booking.ma_khach_hang).name,
                'Phòng': booking.ma_phong,
                'Ngày đến': new Date(booking.ngay_den).toLocaleDateString('vi-VN'),
                'Ngày đi': new Date(booking.ngay_di).toLocaleDateString('vi-VN'),
                'Trạng thái': booking.trang_thai
            }));
            worksheetName = 'DatPhong';
            fileName = 'DatPhong.xlsx';
            break;

        case 'invoices':
            data = invoices.map(invoice => ({
                'Mã hóa đơn': invoice.id,
                'Khách hàng': customers.find(c => c.id === invoice.ma_khach_hang).name,
                'Phòng': invoice.ma_phong,
                'Ngày lập': new Date(invoice.ngay_lap).toLocaleDateString('vi-VN'),
                'Tổng tiền': invoice.tong_tien.toLocaleString('vi-VN') + ' VNĐ',
                'Trạng thái': invoice.trang_thai
            }));
            worksheetName = 'HoaDon';
            fileName = 'HoaDon.xlsx';
            break;
    }

    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.json_to_sheet(data);
    XLSX.utils.book_append_sheet(wb, ws, worksheetName);
    XLSX.writeFile(wb, fileName);
}