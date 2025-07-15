// Sample data - Replace with actual API calls to your backend
const sampleData = {
    rooms: [
        { id: 'P101', name: 'Phòng Đôi Cao Cấp', type: 'Đôi', status: 'Trống', price: '1,500,000' },
        { id: 'P102', name: 'Phòng Đơn Tiêu Chuẩn', type: 'Đơn', status: 'Đã đặt', price: '800,000' },
        { id: 'P201', name: 'Phòng Gia Đình', type: 'Gia đình', status: 'Đang sửa chữa', price: '2,200,000' },
        { id: 'P202', name: 'Phòng Đôi View Biển', type: 'Đôi', status: 'Trống', price: '2,800,000' },
        { id: 'P301', name: 'Suite Tổng Thống', type: 'Suite', status: 'Đang sử dụng', price: '5,000,000' }
    ],
    invoices: [
        { id: 'HD001', customer: 'Nguyễn Văn A', room: 'P101', checkIn: '24/07/2025', checkOut: '26/07/2025', total: '3,000,000', status: 'Đã thanh toán' },
        { id: 'HD002', customer: 'Trần Thị B', room: 'P102', checkIn: '23/07/2025', checkOut: '25/07/2025', total: '1,600,000', status: 'Đã thanh toán' },
        { id: 'HD003', customer: 'Lê Văn C', room: 'P201', checkIn: '25/07/2025', checkOut: '28/07/2025', total: '6,600,000', status: 'Chưa thanh toán' }
    ],
    customers: [
        { id: 'KH001', name: 'Nguyễn Văn A', email: 'nguyenvana@email.com', phone: '0912345678', address: 'Hà Nội' },
        { id: 'KH002', name: 'Trần Thị B', email: 'tranthib@email.com', phone: '0987654321', address: 'TP.HCM' },
        { id: 'KH003', name: 'Lê Văn C', email: 'levanc@email.com', phone: '0905123456', address: 'Đà Nẵng' }
    ],
    revenue: [
        { month: '01/2025', invoices: 12, total: '18,500,000' },
        { month: '02/2025', invoices: 10, total: '15,750,000' },
        { month: '03/2025', invoices: 15, total: '22,300,000' },
        { month: '04/2025', invoices: 8, total: '12,100,000' },
        { month: '05/2025', invoices: 20, total: '28,900,000' }
    ]
};

// DOM Elements
const loadingOverlay = document.getElementById('loadingOverlay');
const previewTable = document.getElementById('previewTable');
const previewTableBody = document.getElementById('previewTableBody');
const previewDataType = document.getElementById('previewDataType');
const startDateInput = document.getElementById('startDate');
const endDateInput = document.getElementById('endDate');
const reportType = document.getElementById('reportType');
const btnPrev = document.getElementById('btnPrev');
const btnNext = document.getElementById('btnNext');
const pageInfo = document.getElementById('pageInfo');

// Pagination
let currentPage = 1;
const itemsPerPage = 10;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    // Set default date range (current month)
    const today = new Date();
    const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
    const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
    
    startDateInput.valueAsDate = firstDay;
    endDateInput.valueAsDate = lastDay;
    
    // Initialize data preview
    updatePreview();
    
    // Set up event listeners
    btnPrev.addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            updatePreview();
        }
    });
    
    btnNext.addEventListener('click', () => {
        const data = getCurrentData();
        const totalPages = Math.ceil(data.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            updatePreview();
        }
    });
});

// Handle export to Excel
function exportToExcel(type) {
    showLoading();
    
    // Simulate API call delay
    setTimeout(() => {
        try {
            let data, fileName, sheetName;
            
            switch(type) {
                case 'all':
                    // Export all data to separate sheets
                    const wb = XLSX.utils.book_new();
                    
                    // Add rooms sheet
                    const roomsWS = XLSX.utils.json_to_sheet(sampleData.rooms);
                    XLSX.utils.book_append_sheet(wb, roomsWS, 'Phòng');
                    
                    // Add invoices sheet
                    const invoicesWS = XLSX.utils.json_to_sheet(sampleData.invoices);
                    XLSX.utils.book_append_sheet(wb, invoicesWS, 'Hóa đơn');
                    
                    // Add customers sheet
                    const customersWS = XLSX.utils.json_to_sheet(sampleData.customers);
                    XLSX.utils.book_append_sheet(wb, customersWS, 'Khách hàng');
                    
                    // Add revenue sheet
                    const revenueWS = XLSX.utils.json_to_sheet(sampleData.revenue);
                    XLSX.utils.book_append_sheet(wb, revenueWS, 'Doanh thu');
                    
                    XLSX.writeFile(wb, `Bao_Cao_Toan_Bo_${formatDate(new Date())}.xlsx`);
                    break;
                    
                case 'rooms':
                    data = sampleData.rooms;
                    fileName = 'Danh_Sach_Phong.xlsx';
                    sheetName = 'Phòng';
                    exportDataToExcel(data, fileName, sheetName);
                    break;
                    
                case 'invoices':
                    const startDate = startDateInput.value;
                    const endDate = endDateInput.value;
                    // In a real app, filter invoices by date range
                    data = sampleData.invoices;
                    fileName = `Hoa_Don_${formatDate(startDate)}_den_${formatDate(endDate)}.xlsx`;
                    sheetName = 'Hóa đơn';
                    exportDataToExcel(data, fileName, sheetName);
                    break;
                    
                case 'customers':
                    data = sampleData.customers;
                    fileName = 'Danh_Sach_Khach_Hang.xlsx';
                    sheetName = 'Khách hàng';
                    exportDataToExcel(data, fileName, sheetName);
                    break;
                    
                case 'revenue':
                    const type = reportType.value;
                    let reportData = [];
                    
                    // In a real app, generate report data based on type (monthly/quarterly/yearly)
                    if (type === 'monthly') {
                        reportData = sampleData.revenue;
                        fileName = 'Bao_Cao_Doanh_Thu_Theo_Thang.xlsx';
                    } else if (type === 'quarterly') {
                        // Group by quarter
                        reportData = [
                            { quy: 'Quý 1/2025', soLuongHoaDon: 37, tongDoanhThu: '56,550,000' },
                            { quy: 'Quý 2/2025', soLuongHoaDon: 28, tongDoanhThu: '41,000,000' }
                        ];
                        fileName = 'Bao_Cao_Doanh_Thu_Theo_Quy.xlsx';
                    } else {
                        // Yearly
                        reportData = [
                            { nam: '2025', soLuongHoaDon: 65, tongDoanhThu: '97,550,000' }
                        ];
                        fileName = 'Bao_Cao_Doanh_Thu_Theo_Nam.xlsx';
                    }
                    
                    exportDataToExcel(reportData, fileName, 'Báo cáo doanh thu');
                    break;
            }
            
            showSuccess('Xuất dữ liệu thành công!');
        } catch (error) {
            console.error('Lỗi khi xuất Excel:', error);
            showError('Đã xảy ra lỗi khi xuất dữ liệu. Vui lòng thử lại.');
        } finally {
            hideLoading();
        }
    }, 1000);
}

// Helper function to export data to Excel
function exportDataToExcel(data, fileName, sheetName) {
    const ws = XLSX.utils.json_to_sheet(data);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, sheetName);
    XLSX.writeFile(wb, fileName);
}

// Update data preview based on selected type
function updatePreview() {
    const type = previewDataType.value;
    const data = getCurrentData();
    
    // Update pagination
    const totalPages = Math.ceil(data.length / itemsPerPage);
    currentPage = Math.min(currentPage, Math.max(1, totalPages));
    
    // Update pagination controls
    btnPrev.disabled = currentPage <= 1;
    btnNext.disabled = currentPage >= totalPages;
    pageInfo.textContent = `Trang ${currentPage}/${totalPages || 1}`;
    
    // Get current page data
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = Math.min(startIndex + itemsPerPage, data.length);
    const pageData = data.slice(startIndex, endIndex);
    
    // Update table
    previewTableBody.innerHTML = '';
    
    if (pageData.length === 0) {
        const emptyRow = document.createElement('tr');
        emptyRow.innerHTML = `
            <td colspan="5" class="text-center">
                <div class="empty-state">
                    <i class="fas fa-database"></i>
                    <p>Không có dữ liệu để hiển thị</p>
                </div>
            </td>
        `;
        previewTableBody.appendChild(emptyRow);
        return;
    }
    
    // Update table headers based on data type
    updateTableHeaders(type);
    
    // Add data rows
    pageData.forEach(item => {
        const row = document.createElement('tr');
        
        switch(type) {
            case 'rooms':
                row.innerHTML = `
                    <td>${item.id}</td>
                    <td>${item.name}</td>
                    <td>${item.type}</td>
                    <td><span class="badge ${getStatusBadgeClass(item.status)}">${item.status}</span></td>
                    <td class="text-right">${item.price} đ</td>
                `;
                break;
                
            case 'invoices':
                row.innerHTML = `
                    <td>${item.id}</td>
                    <td>${item.customer}</td>
                    <td>${item.room}</td>
                    <td>${item.checkIn}</td>
                    <td>${item.checkOut}</td>
                    <td class="text-right">${item.total} đ</td>
                    <td><span class="badge ${item.status === 'Đã thanh toán' ? 'badge-success' : 'badge-warning'}">${item.status}</span></td>
                `;
                break;
                
            case 'customers':
                row.innerHTML = `
                    <td>${item.id}</td>
                    <td>${item.name}</td>
                    <td>${item.phone}</td>
                    <td>${item.email}</td>
                    <td>${item.address}</td>
                `;
                break;
                
            case 'revenue':
                if (reportType.value === 'monthly') {
                    row.innerHTML = `
                        <td>${item.month}</td>
                        <td>${item.invoices}</td>
                        <td class="text-right">${item.total} đ</td>
                    `;
                } else if (reportType.value === 'quarterly') {
                    row.innerHTML = `
                        <td>${item.quy}</td>
                        <td>${item.soLuongHoaDon}</td>
                        <td class="text-right">${item.tongDoanhThu} đ</td>
                    `;
                } else {
                    row.innerHTML = `
                        <td>${item.nam}</td>
                        <td>${item.soLuongHoaDon}</td>
                        <td class="text-right">${item.tongDoanhThu} đ</td>
                    `;
                }
                break;
        }
        
        previewTableBody.appendChild(row);
    });
}

// Update table headers based on data type
function updateTableHeaders(type) {
    let headers = [];
    
    switch(type) {
        case 'rooms':
            headers = ['Mã phòng', 'Tên phòng', 'Loại phòng', 'Trạng thái', 'Giá/đêm'];
            break;
            
        case 'invoices':
            headers = ['Mã HĐ', 'Khách hàng', 'Phòng', 'Ngày nhận', 'Ngày trả', 'Tổng tiền', 'Trạng thái'];
            break;
            
        case 'customers':
            headers = ['Mã KH', 'Họ tên', 'SĐT', 'Email', 'Địa chỉ'];
            break;
            
        case 'revenue':
            if (reportType.value === 'monthly') {
                headers = ['Tháng', 'Số lượng hóa đơn', 'Tổng doanh thu'];
            } else if (reportType.value === 'quarterly') {
                headers = ['Quý', 'Số lượng hóa đơn', 'Tổng doanh thu'];
            } else {
                headers = ['Năm', 'Số lượng hóa đơn', 'Tổng doanh thu'];
            }
            break;
    }
    
    // Update table headers
    const thead = previewTable.querySelector('thead');
    thead.innerHTML = `<tr>${headers.map(h => `<th>${h}</th>`).join('')}</tr>`;
}

// Get current data based on selected type
function getCurrentData() {
    const type = previewDataType.value;
    
    switch(type) {
        case 'rooms':
            return sampleData.rooms;
            
        case 'invoices':
            // In a real app, filter by date range
            return sampleData.invoices;
            
        case 'customers':
            return sampleData.customers;
            
        case 'revenue':
            if (reportType.value === 'monthly') {
                return sampleData.revenue;
            } else if (reportType.value === 'quarterly') {
                return [
                    { quy: 'Quý 1/2025', soLuongHoaDon: 37, tongDoanhThu: '56,550,000' },
                    { quy: 'Quý 2/2025', soLuongHoaDon: 28, tongDoanhThu: '41,000,000' }
                ];
            } else {
                return [
                    { nam: '2025', soLuongHoaDon: 65, tongDoanhThu: '97,550,000' }
                ];
            }
            
        default:
            return [];
    }
}

// Helper function to format date as DD/MM/YYYY
function formatDate(date) {
    const d = new Date(date);
    let month = '' + (d.getMonth() + 1);
    let day = '' + d.getDate();
    const year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [day, month, year].join('-');
}

// Helper function to get status badge class
function getStatusBadgeClass(status) {
    switch(status) {
        case 'Trống':
            return 'badge-success';
        case 'Đã đặt':
            return 'badge-info';
        case 'Đang sử dụng':
            return 'badge-warning';
        case 'Đang sửa chữa':
            return 'badge-danger';
        default:
            return 'badge-secondary';
    }
}

// Helper function to show loading overlay
function showLoading() {
    loadingOverlay.style.display = 'flex';
}

// Helper function to hide loading overlay
function hideLoading() {
    loadingOverlay.style.display = 'none';
}

// Helper function to show success message
function showSuccess(message) {
    // In a real app, you might use a toast notification library
    alert(message);
}

// Helper function to show error message
function showError(message) {
    // In a real app, you might use a toast notification library
    alert('Lỗi: ' + message);
}
