// DOM Elements
const modal = document.getElementById('modal');
const modalTitle = document.getElementById('modalTitle');
const modalBody = document.getElementById('modalBody');
const closeBtn = document.querySelector('.close');

// Sample data (replace with actual API calls in production)
let rooms = [
    { id: 'P001', so_phong: '101', ma_loai: 'LP001', trang_thai: 'Trống' },
    { id: 'P002', so_phong: '201', ma_loai: 'LP002', trang_thai: 'Đang sử dụng' },
];

let roomTypes = [
    { id: 'LP001', ten_loai: 'Phòng Đơn' },
    { id: 'LP002', ten_loai: 'Phòng Đôi' },
];

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    loadRooms();
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
    document.getElementById('addRoomBtn').addEventListener('click', () => showAddForm('room'));
}

// Show add form in modal
function showAddForm(type) {
    let formHtml = '';
    let title = '';
    
    if (type === 'room') {
        title = 'Thêm phòng mới';
        let roomTypeOptions = roomTypes.map(rt => 
            `<option value="${rt.id}">${rt.ten_loai}</option>`
        ).join('');
        
        formHtml = `
            <div class="form-group">
                <label for="so_phong">Số phòng *</label>
                <input type="text" id="so_phong" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="ma_loai">Loại phòng *</label>
                <select id="ma_loai" class="form-control" required>
                    <option value="">Chọn loại phòng</option>
                    ${roomTypeOptions}
                </select>
            </div>
            <div class="form-group">
                <label for="trang_thai">Trạng thái *</label>
                <select id="trang_thai" class="form-control" required>
                    <option value="Trống">Trống</option>
                    <option value="Đang sử dụng">Đang sử dụng</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Hủy</button>
                <button type="button" class="btn btn-primary" onclick="saveRoom()">Lưu</button>
            </div>
        `;
    }
    
    showModal(title, formHtml);
}

// Show edit form in modal
function showEditForm(id) {
    const room = rooms.find(r => r.id === id);
    if (!room) return;

    let formHtml = `
        <div class="form-group">
            <label for="so_phong">Số phòng *</label>
            <input type="text" id="so_phong" class="form-control" value="${room.so_phong}" required>
        </div>
        <div class="form-group">
            <label for="ma_loai">Loại phòng *</label>
            <select id="ma_loai" class="form-control" required>
                ${roomTypes.map(rt => `<option value="${rt.id}" ${rt.id === room.ma_loai ? 'selected' : ''}>${rt.ten_loai}</option>`).join('')}
            </select>
        </div>
        <div class="form-group">
            <label for="trang_thai">Trạng thái *</label>
            <select id="trang_thai" class="form-control" required>
                <option value="Trống" ${room.trang_thai === 'Trống' ? 'selected' : ''}>Trống</option>
                <option value="Đang sử dụng" ${room.trang_thai === 'Đang sử dụng' ? 'selected' : ''}>Đang sử dụng</option>
            </select>
        </div>
        <div class="form-actions">
            <button type="button" class="btn btn-secondary" onclick="closeModal()">Hủy</button>
            <button type="button" class="btn btn-primary" onclick="saveRoom('${room.id}')">Lưu</button>
        </div>
    `;

    showModal('Chỉnh sửa phòng', formHtml);
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

// Save room
function saveRoom(id = null) {
    const so_phong = document.getElementById('so_phong').value;
    const ma_loai = document.getElementById('ma_loai').value;
    const trang_thai = document.getElementById('trang_thai').value;

    if (id) {
        const roomIndex = rooms.findIndex(r => r.id === id);
        if (roomIndex !== -1) {
            rooms[roomIndex] = { id, so_phong, ma_loai, trang_thai };
        }
    } else {
        const newId = 'P' + String(rooms.length + 1).padStart(3, '0');
        rooms.push({ id: newId, so_phong, ma_loai, trang_thai });
    }

    alert('Đã lưu thông tin phòng');
    closeModal();
    loadRooms();
}

// Load data into table
function loadRooms() {
    const tbody = document.querySelector('#roomsTable tbody');
    tbody.innerHTML = rooms.map(room => `
        <tr>
            <td>${room.id}</td>
            <td>${room.so_phong}</td>
            <td>${roomTypes.find(rt => rt.id === room.ma_loai).ten_loai}</td>
            <td><span class="status ${room.trang_thai === 'Trống' ? 'status-active' : 'status-inactive'}">${room.trang_thai}</span></td>
            <td class="action-btns">
                <button class="btn-edit" onclick="showEditForm('${room.id}')"><i class="fas fa-edit"></i></button>
                <button class="btn-delete" onclick="deleteRoom('${room.id}')"><i class="fas fa-trash"></i></button>
            </td>
        </tr>
    `).join('');
}

// Delete room
function deleteRoom(id) {
    if (confirm('Bạn có chắc chắn muốn xóa phòng này?')) {
        rooms = rooms.filter(r => r.id !== id);
        alert(`Đã xóa phòng có ID: ${id}`);
        loadRooms();
    }
}