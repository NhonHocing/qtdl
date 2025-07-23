// DOM Elements
const modal = document.getElementById('modal');
const modalTitle = document.getElementById('modalTitle');
const modalBody = document.getElementById('modalBody');
const closeBtn = document.querySelector('.close');

// Sample data (replace with actual API calls in production)
let stats = [
    { id: 'TK001', thang: 'Tháng 7/2025', tong_doanh_thu: '5000000', so_phong_dat: '10', trang_thai: 'Hoàn thành' },
    { id: 'TK002', thang: 'Tháng 6/2025', tong_doanh_thu: '4000000', so_phong_dat: '8', trang_thai: 'Chờ xử lý' },
];

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    loadStats();
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
    document.getElementById('generateStatsBtn').addEventListener('click', () => showAddForm('stats'));
}

// Show add form in modal
function showAddForm(type) {
    let formHtml = '';
    let title = '';
    
    if (type === 'stats') {
        title = 'Tạo thống kê mới';
        formHtml = `
            <div class="form-group">
                <label for="thang">Tháng *</label>
                <input type="text" id="thang" class="form-control" placeholder="Ví dụ: Tháng 7/2025" required>
            </div>
            <div class="form-group">
                <label for="tong_doanh_thu">Tổng doanh thu *</label>
                <input type="number" id="tong_doanh_thu" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="so_phong_dat">Số phòng đặt *</label>
                <input type="number" id="so_phong_dat" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="trang_thai">Trạng thái *</label>
                <select id="trang_thai" class="form-control" required>
                    <option value="Hoàn thành">Hoàn thành</option>
                    <option value="Chờ xử lý">Chờ xử lý</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Hủy</button>
                <button type="button" class="btn btn-primary" onclick="saveStats()">Lưu</button>
            </div>
        `;
    }
    
    showModal(title, formHtml);
}

// Show edit form in modal
function showEditForm(id) {
    const stat = stats.find(s => s.id === id);
    if (!stat) return;

    let formHtml = `
        <div class="form-group">
            <label for="thang">Tháng *</label>
            <input type="text" id="thang" class="form-control" value="${stat.thang}" required>
        </div>
        <div class="form-group">
            <label for="tong_doanh_thu">Tổng doanh thu *</label>
            <input type="number" id="tong_doanh_thu" class="form-control" value="${stat.tong_doanh_thu}" required>
        </div>
        <div class="form-group">
            <label for="so_phong_dat">Số phòng đặt *</label>
            <input type="number" id="so_phong_dat" class="form-control" value="${stat.so_phong_dat}" required>
        </div>
        <div class="form-group">
            <label for="trang_thai">Trạng thái *</label>
            <select id="trang_thai" class="form-control" required>
                <option value="Hoàn thành" ${stat.trang_thai === 'Hoàn thành' ? 'selected' : ''}>Hoàn thành</option>
                <option value="Chờ xử lý" ${stat.trang_thai === 'Chờ xử lý' ? 'selected' : ''}>Chờ xử lý</option>
            </select>
        </div>
        <div class="form-actions">
            <button type="button" class="btn btn-secondary" onclick="closeModal()">Hủy</button>
            <button type="button" class="btn btn-primary" onclick="saveStats('${stat.id}')">Lưu</button>
        </div>
    `;

    showModal('Chỉnh sửa thống kê', formHtml);
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

// Save stats
function saveStats(id = null) {
    const thang = document.getElementById('thang').value;
    const tong_doanh_thu = document.getElementById('tong_doanh_thu').value;
    const so_phong_dat = document.getElementById('so_phong_dat').value;
    const trang_thai = document.getElementById('trang_thai').value;

    if (id) {
        const statIndex = stats.findIndex(s => s.id === id);
        if (statIndex !== -1) {
            stats[statIndex] = { id, thang, tong_doanh_thu, so_phong_dat, trang_thai };
        }
    } else {
        const newId = 'TK' + String(stats.length + 1).padStart(3, '0');
        stats.push({ id: newId, thang, tong_doanh_thu, so_phong_dat, trang_thai });
    }

    alert('Đã lưu thông tin thống kê');
    closeModal();
    loadStats();
}

// Load data into table
function loadStats() {
    const tbody = document.querySelector('#statsTable tbody');
    tbody.innerHTML = stats.map(stat => `
        <tr>
            <td>${stat.thang}</td>
            <td>${stat.tong_doanh_thu} VND</td>
            <td>${stat.so_phong_dat}</td>
            <td><span class="status ${stat.trang_thai === 'Hoàn thành' ? 'status-completed' : 'status-pending'}">${stat.trang_thai}</span></td>
            <td class="action-btns">
                <button class="btn-edit" onclick="showEditForm('${stat.id}')"><i class="fas fa-edit"></i></button>
                <button class="btn-delete" onclick="deleteStats('${stat.id}')"><i class="fas fa-trash"></i></button>
            </td>
        </tr>
    `).join('');
}

// Delete stats
function deleteStats(id) {
    if (confirm('Bạn có chắc chắn muốn xóa thống kê này?')) {
        stats = stats.filter(s => s.id !== id);
        alert(`Đã xóa thống kê có ID: ${id}`);
        loadStats();
    }
}