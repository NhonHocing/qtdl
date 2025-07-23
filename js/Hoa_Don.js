// DOM Elements
const modal = document.getElementById('modal');
const modalTitle = document.getElementById('modalTitle');
const modalBody = document.getElementById('modalBody');
const closeBtn = document.querySelector('.close');

// Sample data (replace with actual API calls in production)
let invoices = [
    { id: 'HD001', bookingId: 'DP001', khach_hang: 'Nguyen Van A', tong_tien: '2000000', ngay_thanh_toan: '2025-07-27', trang_thai: 'Đã thanh toán' },
    { id: 'HD002', bookingId: 'DP002', khach_hang: 'Tran Thi B', tong_tien: '3000000', ngay_thanh_toan: '2025-07-28', trang_thai: 'Chưa thanh toán' },
];

let bookings = [
    { id: 'DP001', so_phong: '101' },
    { id: 'DP002', so_phong: '201' },
];

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    loadInvoices();
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
    document.getElementById('addInvoiceBtn').addEventListener('click', () => showAddForm('invoice'));
}

// Show add form in modal
function showAddForm(type) {
    let formHtml = '';
    let title = '';
    
    if (type === 'invoice') {
        title = 'Thêm hóa đơn mới';
        let bookingOptions = bookings.map(b => 
            `<option value="${b.id}">${b.so_phong}</option>`
        ).join('');
        
        formHtml = `
            <div class="form-group">
                <label for="bookingId">Mã đặt phòng *</label>
                <select id="bookingId" class="form-control" required>
                    <option value="">Chọn đặt phòng</option>
                    ${bookingOptions}
                </select>
            </div>
            <div class="form-group">
                <label for="khach_hang">Khách hàng *</label>
                <input type="text" id="khach_hang" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="tong_tien">Tổng tiền *</label>
                <input type="number" id="tong_tien" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="ngay_thanh_toan">Ngày thanh toán *</label>
                <input type="date" id="ngay_thanh_toan" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="trang_thai">Trạng thái *</label>
                <select id="trang_thai" class="form-control" required>
                    <option value="Đã thanh toán">Đã thanh toán</option>
                    <option value="Chưa thanh toán">Chưa thanh toán</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Hủy</button>
                <button type="button" class="btn btn-primary" onclick="saveInvoice()">Lưu</button>
            </div>
        `;
    }
    
    showModal(title, formHtml);
}

// Show edit form in modal
function showEditForm(id) {
    const invoice = invoices.find(i => i.id === id);
    if (!invoice) return;

    let formHtml = `
        <div class="form-group">
            <label for="bookingId">Mã đặt phòng *</label>
            <select id="bookingId" class="form-control" required>
                ${bookings.map(b => `<option value="${b.id}" ${b.id === invoice.bookingId ? 'selected' : ''}>${b.so_phong}</option>`).join('')}
            </select>
        </div>
        <div class="form-group">
            <label for="khach_hang">Khách hàng *</label>
            <input type="text" id="khach_hang" class="form-control" value="${invoice.khach_hang}" required>
        </div>
        <div class="form-group">
            <label for="tong_tien">Tổng tiền *</label>
            <input type="number" id="tong_tien" class="form-control" value="${invoice.tong_tien}" required>
        </div>
        <div class="form-group">
            <label for="ngay_thanh_toan">Ngày thanh toán *</label>
            <input type="date" id="ngay_thanh_toan" class="form-control" value="${invoice.ngay_thanh_toan}" required>
        </div>
        <div class="form-group">
            <label for="trang_thai">Trạng thái *</label>
            <select id="trang_thai" class="form-control" required>
                <option value="Đã thanh toán" ${invoice.trang_thai === 'Đã thanh toán' ? 'selected' : ''}>Đã thanh toán</option>
                <option value="Chưa thanh toán" ${invoice.trang_thai === 'Chưa thanh toán' ? 'selected' : ''}>Chưa thanh toán</option>
            </select>
        </div>
        <div class="form-actions">
            <button type="button" class="btn btn-secondary" onclick="closeModal()">Hủy</button>
            <button type="button" class="btn btn-primary" onclick="saveInvoice('${invoice.id}')">Lưu</button>
        </div>
    `;

    showModal('Chỉnh sửa hóa đơn', formHtml);
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

// Save invoice
function saveInvoice(id = null) {
    const bookingId = document.getElementById('bookingId').value;
    const khach_hang = document.getElementById('khach_hang').value;
    const tong_tien = document.getElementById('tong_tien').value;
    const ngay_thanh_toan = document.getElementById('ngay_thanh_toan').value;
    const trang_thai = document.getElementById('trang_thai').value;

    if (id) {
        const invoiceIndex = invoices.findIndex(i => i.id === id);
        if (invoiceIndex !== -1) {
            invoices[invoiceIndex] = { id, bookingId, khach_hang, tong_tien, ngay_thanh_toan, trang_thai };
        }
    } else {
        const newId = 'HD' + String(invoices.length + 1).padStart(3, '0');
        invoices.push({ id: newId, bookingId, khach_hang, tong_tien, ngay_thanh_toan, trang_thai });
    }

    alert('Đã lưu thông tin hóa đơn');
    closeModal();
    loadInvoices();
}

// Load data into table
function loadInvoices() {
    const tbody = document.querySelector('#invoicesTable tbody');
    tbody.innerHTML = invoices.map(invoice => `
        <tr>
            <td>${invoice.id}</td>
            <td>${bookings.find(b => b.id === invoice.bookingId).so_phong}</td>
            <td>${invoice.khach_hang}</td>
            <td>${invoice.tong_tien} VND</td>
            <td>${invoice.ngay_thanh_toan}</td>
            <td><span class="status ${invoice.trang_thai === 'Đã thanh toán' ? 'status-paid' : 'status-unpaid'}">${invoice.trang_thai}</span></td>
            <td class="action-btns">
                <button class="btn-edit" onclick="showEditForm('${invoice.id}')"><i class="fas fa-edit"></i></button>
                <button class="btn-delete" onclick="deleteInvoice('${invoice.id}')"><i class="fas fa-trash"></i></button>
            </td>
        </tr>
    `).join('');
}

// Delete invoice
function deleteInvoice(id) {
    if (confirm('Bạn có chắc chắn muốn xóa hóa đơn này?')) {
        invoices = invoices.filter(i => i.id !== id);
        alert(`Đã xóa hóa đơn có ID: ${id}`);
        loadInvoices();
    }
}