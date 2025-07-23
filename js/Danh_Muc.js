// DOM Elements
const modal = document.getElementById('modal');
const modalTitle = document.getElementById('modalTitle');
const modalBody = document.getElementById('modalBody');
const closeBtn = document.querySelector('.close');

// Sample data (replace with actual API calls in production)
let categories = [
    { id: 'DM001', ten_danh_muc: 'Loại phòng', mo_ta: 'Quản lý các loại phòng' },
    { id: 'DM002', ten_danh_muc: 'Dịch vụ', mo_ta: 'Quản lý dịch vụ khách sạn' },
];

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    loadCategories();
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
    document.getElementById('addCategoryBtn').addEventListener('click', () => showAddForm('category'));
}

// Show add form in modal
function showAddForm(type) {
    let formHtml = '';
    let title = '';
    
    if (type === 'category') {
        title = 'Thêm danh mục mới';
        formHtml = `
            <div class="form-group">
                <label for="ten_danh_muc">Tên danh mục *</label>
                <input type="text" id="ten_danh_muc" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="mo_ta">Mô tả *</label>
                <input type="text" id="mo_ta" class="form-control" required>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Hủy</button>
                <button type="button" class="btn btn-primary" onclick="saveCategory()">Lưu</button>
            </div>
        `;
    }
    
    showModal(title, formHtml);
}

// Show edit form in modal
function showEditForm(id) {
    const category = categories.find(c => c.id === id);
    if (!category) return;

    let formHtml = `
        <div class="form-group">
            <label for="ten_danh_muc">Tên danh mục *</label>
            <input type="text" id="ten_danh_muc" class="form-control" value="${category.ten_danh_muc}" required>
        </div>
        <div class="form-group">
            <label for="mo_ta">Mô tả *</label>
            <input type="text" id="mo_ta" class="form-control" value="${category.mo_ta}" required>
        </div>
        <div class="form-actions">
            <button type="button" class="btn btn-secondary" onclick="closeModal()">Hủy</button>
            <button type="button" class="btn btn-primary" onclick="saveCategory('${category.id}')">Lưu</button>
        </div>
    `;

    showModal('Chỉnh sửa danh mục', formHtml);
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

// Save category
function saveCategory(id = null) {
    const ten_danh_muc = document.getElementById('ten_danh_muc').value;
    const mo_ta = document.getElementById('mo_ta').value;

    if (id) {
        const categoryIndex = categories.findIndex(c => c.id === id);
        if (categoryIndex !== -1) {
            categories[categoryIndex] = { id, ten_danh_muc, mo_ta };
        }
    } else {
        const newId = 'DM' + String(categories.length + 1).padStart(3, '0');
        categories.push({ id: newId, ten_danh_muc, mo_ta });
    }

    alert('Đã lưu thông tin danh mục');
    closeModal();
    loadCategories();
}

// Load data into table
function loadCategories() {
    const tbody = document.querySelector('#categoriesTable tbody');
    tbody.innerHTML = categories.map(category => `
        <tr>
            <td>${category.id}</td>
            <td>${category.ten_danh_muc}</td>
            <td>${category.mo_ta}</td>
            <td class="action-btns">
                <button class="btn-edit" onclick="showEditForm('${category.id}')"><i class="fas fa-edit"></i></button>
                <button class="btn-delete" onclick="deleteCategory('${category.id}')"><i class="fas fa-trash"></i></button>
            </td>
        </tr>
    `).join('');
}

// Delete category
function deleteCategory(id) {
    if (confirm('Bạn có chắc chắn muốn xóa danh mục này?')) {
        categories = categories.filter(c => c.id !== id);
        alert(`Đã xóa danh mục có ID: ${id}`);
        loadCategories();
    }
}