// DOM Elements
const tabBtns = document.querySelectorAll('.tab-btn');
const tabPanes = document.querySelectorAll('.tab-pane');
const modal = document.getElementById('modal');
const modalTitle = document.getElementById('modalTitle');
const modalBody = document.getElementById('modalBody');
const closeBtn = document.querySelector('.close');

async function loadData(key, apiUrl, fallbackData = []) {

  try {
    const response = await fetch(apiUrl);
    if (!response.ok) throw new Error(`API ${key} lỗi`);
    const data = await response.json();
    // console.log(data)
    return data;
  } catch (err) {
    console.error(`Không thể tải ${key} từ API. Dùng dữ liệu mẫu.`, err);
    return fallbackData;
  }
}

let accounts = [];
let employees = [];
let customers = [];
let roomTypes = [];
let rooms = [];
let services = [];
let serviceUsages = [];

async function initAppData() {
  accounts = await loadData("accounts", "http://localhost:8000/api/categories/accounts/");
  employees = await loadData("employees", "http://localhost:8000/api/categories/staffs/");
  customers = await loadData("customers", "http://localhost:8000/api/categories/customers/");
  roomTypes = await loadData("roomTypes", "http://localhost:8000/api/categories/room-types/");
  rooms = await loadData("rooms", "http://localhost:8000/api/categories/rooms/");
  services = await loadData("services", "http://localhost:8000/api/categories/services/");
  serviceUsages = await loadData("serviceUsages", "http://localhost:8000/api/categories/service-usages/");

    data = {
        accounts: accounts,
        employees: employees,
        customers: customers,
        roomTypes: roomTypes,
        rooms: rooms,
        services: services,
        serviceUsages: serviceUsages
    };
    return data;
}
// Initialize the page
async function init() {
    document.addEventListener('DOMContentLoaded', async function() {
    data = await initAppData();
    console.log(data);
    // Initialize tabs
    initTabs();
    
    // Load initial data
    loadAccounts(data.accounts);
    loadEmployees(data.employees);
    loadCustomers(data.customers);
    loadRoomTypes(data.roomTypes);
    loadServices(data.services);
    loadRooms(data.rooms, data.roomTypes);
    loadServiceUsages(data.serviceUsages, data.customers, data.services);
    
    // Set up event listeners
    setupEventListeners();
});
}

// Initialize tab functionality
function initTabs() {
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            
            // Remove active class from all buttons and panes
            tabBtns.forEach(btn => btn.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));
            
            // Add active class to clicked button and corresponding pane
            this.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        });
    });
}

// Set up event listeners
function setupEventListeners() {
    // Close modal when clicking the X button
    closeBtn.addEventListener('click', closeModal);
    
    // Close modal when clicking outside the modal content
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });
    
    // Add event listeners for "Thêm mới" buttons
    document.getElementById('addAccountBtn').addEventListener('click', () => showAddForm('account'));
    document.getElementById('addEmployeeBtn').addEventListener('click', () => showAddForm('employee'));
    document.getElementById('addCustomerBtn').addEventListener('click', () => showAddForm('customer'));
    document.getElementById('addRoomTypeBtn').addEventListener('click', () => showAddForm('roomType'));
    document.getElementById('addServiceBtn').addEventListener('click', () => showAddForm('service'));
    document.getElementById('addRoomBtn').addEventListener('click', () => showAddForm('room'));
    document.getElementById('addServiceUsageBtn').addEventListener('click', () => showAddForm('serviceUsage'));
}

// Show add form in modal
function showAddForm(type) {
    let formHtml = '';
    let title = '';
    
    switch (type) {
        case 'account':
            title = 'Thêm tài khoản mới';
            let employeeOptions = employees.map(e => 
                `<option value="${e.id}">${e.id} - ${e.name}</option>`
            ).join('');
            
            formHtml = `
                <div class="form-group">
                    <label for="username">Tên đăng nhập *</label>
                    <input type="text" id="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu *</label>
                    <input type="password" id="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="ma_nhan_vien">Nhân viên *</label>
                    <select id="ma_nhan_vien" class="form-control" required>
                        <option value="">Chọn nhân viên</option>
                        ${employeeOptions}
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu *</label>
                    <input type="password" id="password" class="form-control" required>
                </div>
                <div class="form-group">
            `;
            break;
            
        case 'room':
            title = 'Thêm phòng mới';
            let roomTypeOptions = roomTypes.map(rt => 
                `<option value="${rt.id}">${rt.name}</option>`
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
            `;
            break;
                
        case 'serviceUsage':
            title = 'Thêm sử dụng dịch vụ mới';
            let customerOptions = customers.map(c => 
                `<option value="${c.id}">${c.id} - ${c.name}</option>`
            ).join('');
            
            let serviceOptions = services.map(s => 
                `<option value="${s.id}">${s.name} (${parseInt(s.price).toLocaleString()}đ)</option>`
            ).join('');
            
            formHtml = `
                <div class="form-group">
                    <label for="ma_khach_hang">Khách hàng *</label>
                    <select id="ma_khach_hang" class="form-control" required>
                        <option value="">Chọn khách hàng</option>
                        ${customerOptions}
                    </select>
                </div>
                <div class="form-group">
                    <label for="ma_dich_vu">Dịch vụ *</label>
                    <select id="ma_dich_vu" class="form-control" required>
                        <option value="">Chọn dịch vụ</option>
                        ${serviceOptions}
                    </select>
                </div>
                <div class="form-group">
                    <label for="so_luong">Số lượng *</label>
                    <input type="number" id="so_luong" class="form-control" min="1" value="1" required>
                </div>
                <div class="form-group">
                    <label for="ngay_su_dung">Ngày sử dụng *</label>
                    <input type="date" id="ngay_su_dung" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="status">Trạng thái *</label>
                    <select id="status" class="form-control" required>
                        <option value="Chưa thanh toán">Chưa thanh toán</option>
                        <option value="Đã thanh toán">Đã thanh toán</option>
                    </select>
                </div>
            `;
            break;
                
        case 'employee':
            title = 'Thêm nhân viên mới';
            formHtml = `
                <div class="form-group">
                    <label for="name">Họ tên *</label>
                    <input type="text" id="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="dob">Ngày sinh *</label>
                    <input type="date" id="dob" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại *</label>
                    <input type="tel" id="phone" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="role">Vai trò *</label>
                    <select id="role" class="form-control" required>
                        <option value="admin">Admin</option>
                        <option value="staff">Nhân viên</option>
                    </select>
                </div>
            `;
            break;
            
        case 'customer':
            title = 'Thêm khách hàng mới';
            formHtml = `
                <div class="form-group">
                    <label for="custName">Tên khách hàng *</label>
                    <input type="text" id="custName" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="custAddress">Địa chỉ *</label>
                    <input type="text" id="custAddress" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="custPhone">Số điện thoại *</label>
                    <input type="tel" id="custPhone" class="form-control" required>
                </div>
            `;
            break;
            
        case 'roomType':
            title = 'Thêm loại phòng mới';
            formHtml = `
                <div class="form-group">
                    <label for="roomTypeName">Tên loại phòng *</label>
                    <input type="text" id="roomTypeName" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="roomPrice">Giá phòng (VNĐ) *</label>
                    <input type="number" id="roomPrice" class="form-control" min="0" required>
                </div>
            `;
            break;
            
        case 'service':
            title = 'Thêm dịch vụ mới';
            formHtml = `
                <div class="form-group">
                    <label for="serviceName">Tên dịch vụ *</label>
                    <input type="text" id="serviceName" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="servicePrice">Giá dịch vụ (VNĐ) *</label>
                    <input type="number" id="servicePrice" class="form-control" min="0" required>
                </div>
            `;
            break;
    }
    
    // Add form actions
    formHtml += `
        <div class="form-actions">
            <button type="button" class="btn btn-secondary" onclick="closeModal()">Hủy</button>
            <button type="button" class="btn btn-primary" onclick="save${type.charAt(0).toUpperCase() + type.slice(1)}()">Lưu</button>
        </div>
    `;
    
    // Show modal with form
    showModal(title, formHtml);
}

// Show edit form in modal
function showEditForm(type, id) {
    // In a real application, you would fetch the data for the specific item
    // For now, we'll just show the same form as add but with a different title
    showAddForm(type);
    modalTitle.textContent = `Chỉnh sửa ${getTypeName(type)}`;
    
    // Here you would populate the form with existing data
    // For example:
    // const item = getItemById(type, id);
    // document.getElementById('fieldName').value = item.fieldName;
    // ...
}

// Get display name for type
function getTypeName(type) {
    const types = {
        'account': 'tài khoản',
        'employee': 'nhân viên',
        'customer': 'khách hàng',
        'roomType': 'loại phòng',
        'room': 'phòng',
        'service': 'dịch vụ',
        'serviceUsage': 'sử dụng dịch vụ'
    };
    return types[type] || 'mục';
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

// Save functions for each type
function saveAccount(accounts) {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const email = document.getElementById('email').value;
    
    // Generate new ID if adding new account
    const newId = 'TK' + String(accounts.length + 1).padStart(3, '0');
    
    // Add new account to the array
    accounts.push({
        id: newId,
        username: username,
        password: password,
        email: email
    });
    
    alert('Đã lưu thông tin tài khoản');
    closeModal();
    loadAccounts(); // Refresh the table
}

function saveEmployee(employees) {
    const name = document.getElementById('empName').value;
    const dob = document.getElementById('dob').value;
    const phone = document.getElementById('phone').value;
    const role = document.getElementById('role').value;
    
    // Generate new ID if adding new employee
    const newId = 'NV' + String(employees.length + 1).padStart(3, '0');
    
    // Add new employee to the array
    employees.push({
        id: newId,
        name: name,
        dob: dob,
        phone: phone,
        role: role
    });
    
    alert('Đã lưu thông tin nhân viên');
    closeModal();
    loadEmployees();
}

function saveCustomer(customers) {
    const name = document.getElementById('custName').value;
    const address = document.getElementById('custAddress').value;
    const phone = document.getElementById('custPhone').value;
    
    // Generate new ID if adding new customer
    const newId = 'KH' + String(customers.length + 1).padStart(3, '0');
    
    // Add new customer to the array
    customers.push({
        id: newId,
        name: name,
        address: address,
        phone: phone
    });
    
    alert('Đã lưu thông tin khách hàng');
    closeModal();
    loadCustomers();
}

function saveRoomType(roomTypes) {
    const name = document.getElementById('roomTypeName').value;
    const price = document.getElementById('roomPrice').value;
    
    // Generate new ID if adding new room type
    const newId = 'LP' + String(roomTypes.length + 1).padStart(3, '0');
    
    // Add new room type to the array
    roomTypes.push({
        id: newId,
        name: name,
        price: price
    });
    
    alert('Đã lưu thông tin loại phòng');
    closeModal();
    loadRoomTypes();
}

function saveRoom(rooms) {
    const so_phong = document.getElementById('so_phong').value;
    const ma_loai = document.getElementById('ma_loai').value;
    const trang_thai = document.getElementById('trang_thai').value;
    
    // Generate new ID if adding new room
    const newId = 'P' + String(rooms.length + 1).padStart(3, '0');
    
    // Add new room to the array
    rooms.push({
        id: newId,
        so_phong: so_phong,
        ma_loai: ma_loai,
        trang_thai: trang_thai
    });
    
    alert('Đã lưu thông tin phòng');
    closeModal();
    loadRooms();
}

function saveService(services) {
    const name = document.getElementById('serviceName').value;
    const price = document.getElementById('servicePrice').value;
    
    // Generate new ID if adding new service
    const newId = 'DV' + String(services.length + 1).padStart(3, '0');
    
    // Add new service to the array
    services.push({
        id: newId,
        name: name,
        price: price
    });
    
    alert('Đã lưu thông tin dịch vụ');
    closeModal();
    loadServices();
}

function saveServiceUsage(serviceUsages) {
    const ma_khach_hang = document.getElementById('ma_khach_hang').value;
    const ma_dich_vu = document.getElementById('ma_dich_vu').value;
    const so_luong = parseInt(document.getElementById('so_luong').value);
    const ngay_su_dung = document.getElementById('ngay_su_dung').value;
    const status = document.getElementById('status').value;
    
    // Generate new ID if adding new service usage
    const newId = 'SDV' + String(serviceUsages.length + 1).padStart(3, '0');
    
    // Add new service usage to the array
    serviceUsages.push({
        id: newId,
        ma_khach_hang: ma_khach_hang,
        ma_dich_vu: ma_dich_vu,
        so_luong: so_luong,
        ngay_su_dung: ngay_su_dung,
        status: status,
        hoa_don: '' // Will be set when creating invoice
    });
    
    alert('Đã lưu thông tin sử dụng dịch vụ');
    closeModal();
    loadServiceUsages();
}

// Load data into tables
function loadAccounts(accounts) {
    console.log(accounts)
    const tbody = document.querySelector('#accountsTable tbody');
    tbody.innerHTML = accounts.map(account => {
        // Find the employee associated with this account
        const employee = account.ma_nhan_vien ? employees.find(emp => emp.id === account.ma_nhan_vien) : null;
        const employeeDisplay = employee ? `${employee.id} - ${employee.name}` : 'Chưa gán';
        
        return `
        <tr>
            <td>${account.id}</td>
            <td>${account.username}</td>
            <td>••••••••</td>
            <td>${account.email}</td>
            <td>${employeeDisplay}</td>
            <td class="action-btns">
                <button class="btn-edit" onclick="showEditForm('account', '${account.id}')"><i class="fas fa-edit"></i></button>
                <button class="btn-delete" onclick="deleteItem('account', '${account.id}')"><i class="fas fa-trash"></i></button>
            </td>
        </tr>
        `;
    }).join('');
}

function loadEmployees(employees) {
    const tbody = document.querySelector('#employeesTable tbody');
    tbody.innerHTML = employees.map(emp => `
        <tr>
            <td>${emp.ma_nhan_vien}</td>
            <td>${emp.ho_ten}</td>
            <td>${new Date(emp.ngay_sinh).toLocaleDateString('vi-VN')}</td>
            <td>${emp.so_dien_thoai}</td>
            <td>${emp.role === 'admin' ? 'Quản trị' : 'Nhân viên'}</td>
            <td class="action-btns">
                <button class="btn-edit" onclick="showEditForm('employee', '${emp.ma_nhan_vien}')"><i class="fas fa-edit"></i></button>
                <button class="btn-delete" onclick="deleteItem('employee', '${emp.ma_nhan_vien}')"><i class="fas fa-trash"></i></button>
            </td>
        </tr>
    `).join('');
}

function loadCustomers(customers) {
    const tbody = document.querySelector('#customersTable tbody');
    tbody.innerHTML = customers.map(cust => `
        <tr>
            <td>${cust.ma_khach_hang}</td>
            <td>${cust.ten_khach_hang}</td>
            <td>${cust.dia_chi}</td>
            <td>${cust.so_dien_thoai}</td>
            <td class="action-btns">
                <button class="btn-edit" onclick="showEditForm('customer', '${cust.ma_khach_hang}')"><i class="fas fa-edit"></i></button>
                <button class="btn-delete" onclick="deleteItem('customer', '${cust.ma_khach_hang}')"><i class="fas fa-trash"></i></button>
            </td>
        </tr>
    `).join('');
}

function loadRoomTypes(roomTypes) {
    const tbody = document.querySelector('#roomTypesTable tbody');
    tbody.innerHTML = roomTypes.map(rt => `
        <tr>
            <td>${rt.ma_loai}</td>
            <td>${rt.ten_loai}</td>
            <td>${parseInt(rt.gia_phong).toLocaleString('vi-VN')} VNĐ</td>
            <td class="action-btns">
                <button class="btn-edit" onclick="showEditForm('roomType', '${rt.ma_loai}')"><i class="fas fa-edit"></i></button>
                <button class="btn-delete" onclick="deleteItem('roomType', '${rt.ma_loai}')"><i class="fas fa-trash"></i></button>
            </td>
        </tr>
    `).join('');
}

// {
//     "ma_loai": "RT02",
//     "so_phong": "104",
//     "trang_thai": "Trống",
//     "ma_phong": "F1-104"
// }

function loadRooms(rooms, roomTypes) {
    const tbody = document.querySelector('#roomsTable tbody');
    tbody.innerHTML = rooms.map(room => `
        <tr>
            <td>${room.ma_phong}</td>
            <td>${roomTypes.find(rt => rt.ma_loai === room.ma_loai).ten_loai}</td>
            <td>${room.so_phong}</td>
            <td>${room.trang_thai}</td>
            <td class="action-btns">
                <button class="btn-edit" onclick="showEditForm('room', '${room.ma_phong}')"><i class="fas fa-edit"></i></button>
                <button class="btn-delete" onclick="deleteItem('room', '${room.ma_phong}')"><i class="fas fa-trash"></i></button>
            </td>
        </tr>
    `).join('');
}

function loadServices(services) {
    const tbody = document.querySelector('#servicesTable tbody');
    tbody.innerHTML = services.map(svc => `
        <tr>
            <td>${svc.ma_dich_vu}</td>
            <td>${svc.ten_dich_vu}</td>
            <td>${parseInt(svc.gia_dich_vu).toLocaleString('vi-VN')} VNĐ</td>
            <td class="action-btns">
                <button class="btn-edit" onclick="showEditForm('service', '${svc.ma_dich_vu}')"><i class="fas fa-edit"></i></button>
                <button class="btn-delete" onclick="deleteItem('service', '${svc.ma_dich_vu}')"><i class="fas fa-trash"></i></button>
            </td>
        </tr>
    `).join('');
}

// {
//     "ma_sddv": "SDDV0001",
//     "ma_khach_hang": "KH007",
//     "ma_dich_vu": "DV006",
//     "so_luong": 2,
//     "ngay_su_dung": "2025-01-21",
//     "status": "Đã thanh toán",
//     "ma_nhan_vien": "NV008"
// }

function loadServiceUsages(serviceUsages, customers, services) {
    const tbody = document.querySelector('#serviceUsageTable tbody');
    tbody.innerHTML = serviceUsages.map(su => `
        <tr>
            <td>${su.ma_sddv}</td>
            <td>${customers.find(c => c.ma_khach_hang === su.ma_khach_hang).ten_khach_hang}</td>
            <td>${services.find(s => s.ma_dich_vu === su.ma_dich_vu).ten_dich_vu}</td>
            <td>${su.so_luong}</td>
            <td>${new Date(su.ngay_su_dung).toLocaleDateString('vi-VN')}</td>
            <td>${su.status}</td>
            <td class="action-btns">
                <button class="btn-edit" onclick="showEditForm('serviceUsage', '${su.ma_sddv}')"><i class="fas fa-edit"></i></button>
                <button class="btn-delete" onclick="deleteItem('serviceUsage', '${su.ma_sddv}')"><i class="fas fa-trash"></i></button>
            </td>
        </tr>
    `).join('');
}

// Delete item
function deleteItem(type, id) {
    if (confirm(`Bạn có chắc chắn muốn xóa ${getTypeName(type)} này?`)) {
        // In a real application, you would send a delete request to the server
        alert(`Đã xóa ${getTypeName(type)} có ID: ${id}`);
        
        // Refresh the appropriate table
        switch (type) {
            case 'account': loadAccounts(); break;
            case 'employee': loadEmployees(); break;
            case 'customer': loadCustomers(); break;
            case 'roomType': loadRoomTypes(); break;
            case 'room': loadRooms(); break;
            case 'service': loadServices(); break;
            case 'serviceUsage': loadServiceUsages(); break;
        }
    }
}

// run 
init();
