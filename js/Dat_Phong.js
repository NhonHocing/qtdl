// DOM Elements
const modal = document.getElementById('modal');
const modalTitle = document.getElementById('modalTitle');
const modalBody = document.getElementById('modalBody');
const closeBtn = document.querySelector('.close');

// Sample data (replace with actual API calls in production)
let bookings = [
    { id: 'DP001', roomId: 'P001', khach_hang: 'Nguyen Van A', ngay_nhan: '2025-07-25', ngay_tra: '2025-07-27', trang_thai: 'Đã xác nhận' },
    { id: 'DP002', roomId: 'P002', khach_hang: 'Tran Thi B', ngay_nhan: '2025-07-26', ngay_tra: '2025-07-28', trang_thai: 'Chờ xử lý' },
];

let rooms = [
    { id: 'P001', so_phong: '101' },
    { id: 'P002', so_phong: '201' },
];

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    loadBookings();
    setupEventListeners();
});

// Set up event listeners
function setupEventListeners() {
    closeBtn.addEventListener('click', closeModal);
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });
    document.getElementById('addBookingBtn').addEventListener('click', () => showAddForm('booking'));
}

// Show add form in modal
function showAddForm(type) {
    let formHtml = '';
    let title = '';
    
    if (type === 'booking') {
        title = 'Thêm đặt phòng mới';
        let roomOptions = rooms.map(r => 
            `<option value="${r.id}">${r.so_phong}</option>`
        ).join('');
        
        formHtml = `
            <div class="form-group">
                <label for="roomId">Số phòng *</label>
                <select id="roomId" class="form-control" required>
                    <option value="">Chọn phòng</option>
                    ${roomOptions}
                </select>
            </div>
            <div class="form-group">
                <label for="khach_hang">Khách hàng *</label>
                <input type="text" id="khach_hang" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="ngay_nhan">Ngày nhận *</label>
                <input type="date" id="ngay_nhan" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="ngay_tra">Ngày trả *</label>
                <input type="date" id="ngay_tra" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="trang_thai">Trạng thái *</label>
                <select id="trang_thai" class="form-control" required>
                    <option value="Đã xác nhận">Đã xác nhận</option>
                    <option value="Chờ xử lý">Chờ xử lý</option>
                    <option value="Đã hủy">Đã hủy</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Hủy</button>
                <button type="button" class="btn btn-primary" onclick="saveBooking()">Lưu</button>
            </div>
        `;
    }
    
    showModal(title, formHtml);
}

// Show edit form in modal
function showEditForm(id) {
    const booking = bookings.find(b => b.id === id);
    if (!booking) return;

    let formHtml = `
        <div class="form-group">
            <label for="roomId">Số phòng *</label>
            <select id="roomId" class="form-control" required>
                ${rooms.map(r => `<option value="${r.id}" ${r.id === booking.roomId ? 'selected' : ''}>${r.so_phong}</option>`).join('')}
            </select>
        </div>
        <div class="form-group">
            <label for="khach_hang">Khách hàng *</label>
            <input type="text" id="khach_hang" class="form-control" value="${booking.khach_hang}" required>
        </div>
        <div class="form-group">
            <label for="ngay_nhan">Ngày nhận *</label>
            <input type="date" id="ngay_nhan" class="form-control" value="${booking.ngay_nhan}" required>
        </div>
        <div class="form-group">
            <label for="ngay_tra">Ngày trả *</label>
            <input type="date" id="ngay_tra" class="form-control" value="${booking.ngay_tra}" required>
        </div>
        <div class="form-group">
            <label for="trang_thai">Trạng thái *</label>
            <select id="trang_thai" class="form-control" required>
                <option value="Đã xác nhận" ${booking.trang_thai === 'Đã xác nhận' ? 'selected' : ''}>Đã xác nhận</option>
                <option value="Chờ xử lý" ${booking.trang_thai === 'Chờ xử lý' ? 'selected' : ''}>Chờ xử lý</option>
                <option value="Đã hủy" ${booking.trang_thai === 'Đã hủy' ? 'selected' : ''}>Đã hủy</option>
            </select>
        </div>
        <div class="form-actions">
            <button type="button" class="btn btn-secondary" onclick="closeModal()">Hủy</button>
            <button type="button" class="btn btn-primary" onclick="saveBooking('${booking.id}')">Lưu</button>
        </div>
    `;

    showModal('Chỉnh sửa đặt phòng', formHtml);
}

// Show modal with content
function showModal(title, content) {
    modalTitle.textContent = title;
    modalBody.innerHTML = content;
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

// Close modal
function closeModal() {
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Save booking
function saveBooking(id = null) {
    const roomId = document.getElementById('roomId').value;
    const khach_hang = document.getElementById('khach_hang').value;
    const ngay_nhan = document.getElementById('ngay_nhan').value;
    const ngay_tra = document.getElementById('ngay_tra').value;
    const trang_thai = document.getElementById('trang_thai').value;

    if (id) {
        const bookingIndex = bookings.findIndex(b => b.id === id);
        if (bookingIndex !== -1) {
            bookings[bookingIndex] = { id, roomId, khach_hang, ngay_nhan, ngay_tra, trang_thai };
        }
    } else {
        const newId = 'DP' + String(bookings.length + 1).padStart(3, '0');
        bookings.push({ id: newId, roomId, khach_hang, ngay_nhan, ngay_tra, trang_thai });
    }

    alert('Đã lưu thông tin đặt phòng');
    closeModal();
    loadBookings();
}

// Load data into table
function loadBookings() {
    const tbody = document.querySelector('#bookingsTable tbody');
    tbody.innerHTML = bookings.map(booking => `
        <tr>
            <td>${booking.id}</td>
            <td>${rooms.find(r => r.id === booking.roomId).so_phong}</td>
            <td>${booking.khach_hang}</td>
            <td>${booking.ngay_nhan}</td>
            <td>${booking.ngay_tra}</td>
            <td><span class="status ${booking.trang_thai === 'Đã xác nhận' ? 'status-confirmed' : booking.trang_thai === 'Chờ xử lý' ? 'status-pending' : 'status-cancelled'}">${booking.trang_thai}</span></td>
            <td class="action-btns">
                <button class="btn-edit" onclick="showEditForm('${booking.id}')"><i class="fas fa-edit"></i></button>
                <button class="btn-delete" onclick="deleteBooking('${booking.id}')"><i class="fas fa-trash"></i></button>
            </td>
        </tr>
    `).join('');
}

// Delete booking
function deleteBooking(id) {
    if (confirm('Bạn có chắc chắn muốn xóa đặt phòng này?')) {
        bookings = bookings.filter(b => b.id !== id);
        alert(`Đã xóa đặt phòng có ID: ${id}`);
        loadBookings();
    }
}