// Sample employee data - in a real app, this would come from an API
const employees = [
    { id: 'NV001', name: 'Nguyễn Văn A', dob: '1990-01-01', phone: '0912345678', role: 'admin' },
    { id: 'NV002', name: 'Trần Thị B', dob: '1992-05-15', phone: '0912345679', role: 'staff' },
    { id: 'NV003', name: 'Lê Văn C', dob: '1988-11-20', phone: '0912345680', role: 'staff' }
];

// DOM Elements
const container = document.querySelector('.container');
const registerBtn = document.querySelector('.register-btn');
const loginBtn = document.querySelector('.login-btn');
const registerForm = document.getElementById('registerForm');

// Event Listeners
registerBtn.addEventListener('click', () => {
    container.classList.add('active');
});

loginBtn.addEventListener('click', () => {
    container.classList.remove('active');
});

// Check if all required fields are filled
function areAllFieldsFilled() {
    const hoTen = document.getElementById('ho_ten').value.trim();
    const ngaySinh = document.getElementById('ngay_sinh').value;
    const soDienThoai = document.getElementById('so_dien_thoai').value.trim();
    
    return hoTen !== '' && ngaySinh !== '' && soDienThoai !== '';
}

// Update the disabled state of the employee ID field
function updateEmployeeIdFieldState() {
    const maNVInput = document.getElementById('ma_nhan_vien');
    const allFieldsFilled = areAllFieldsFilled();
    
    // Disable the employee ID field if all other fields are filled
    maNVInput.disabled = allFieldsFilled;
    
    // Add/remove filled class based on whether the field has a value
    if (maNVInput.value.trim() !== '') {
        maNVInput.classList.add('filled');
    } else {
        maNVInput.classList.remove('filled');
    }
    
    return allFieldsFilled;
}

// Check if employee exists and handle form fields
function checkEmployee() {
    const maNV = document.getElementById('ma_nhan_vien').value.trim();
    const employeeFields = document.getElementById('employeeFields');
    const employeeInfo = employees.find(emp => emp.id === maNV);
    const inputs = employeeFields.querySelectorAll('input');

    if (employeeInfo) {
        // Employee exists, auto-fill fields and disable them
        document.getElementById('ho_ten').value = employeeInfo.name;
        document.getElementById('ngay_sinh').value = employeeInfo.dob;
        document.getElementById('so_dien_thoai').value = employeeInfo.phone;
        document.querySelector(`input[name="vai_tro"][value="${employeeInfo.role}"]`).checked = true;
        
        // Disable all employee fields except ma_nhan_vien
        inputs.forEach(input => {
            if (input.id !== 'ma_nhan_vien') {
                input.disabled = true;
            }
        });
        
        // Update employee ID field state
        updateEmployeeIdFieldState();
    } else if (maNV === '') {
        // If ma_nhan_vien is empty, enable all fields and clear them
        inputs.forEach(input => {
            input.disabled = false;
            if (input.name !== 'vai_tro' && input.id !== 'ma_nhan_vien') {
                input.value = '';
            }
        });
        document.querySelector('input[name="vai_tro"][value="staff"]').checked = true;
        
        // Update employee ID field state
        updateEmployeeIdFieldState();
    } else {
        // Employee doesn't exist, enable fields for new employee
        inputs.forEach(input => {
            input.disabled = false;
            if (input.name !== 'vai_tro' && input.id !== 'ma_nhan_vien') {
                input.value = '';
            }
        });
        document.querySelector('input[name="vai_tro"][value="staff"]').checked = true;
        
        // Update employee ID field state
        updateEmployeeIdFieldState();
    }
}

// Add event listeners to all input fields to check when they change
document.addEventListener('DOMContentLoaded', function() {
    // Initialize the form with empty fields
    checkEmployee();
    
    // Add input event listeners to all fields
    const formInputs = document.querySelectorAll('#employeeFields input, #ma_nhan_vien');
    formInputs.forEach(input => {
        input.addEventListener('input', function() {
            if (input.id === 'ma_nhan_vien') {
                // When employee ID changes, clear other fields and enable them
                if (input.value.trim() === '') {
                    // If clearing the employee ID, reset other fields
                    document.getElementById('ho_ten').value = '';
                    document.getElementById('ngay_sinh').value = '';
                    document.getElementById('so_dien_thoai').value = '';
                    document.querySelector('input[name="vai_tro"][value="staff"]').checked = true;
                }
                checkEmployee();
            } else {
                updateEmployeeIdFieldState();
            }
        });
    });
    
    // Add double click event to employee ID field to allow editing when disabled
    const maNVInput = document.getElementById('ma_nhan_vien');
    maNVInput.addEventListener('dblclick', function(e) {
        // Only enable if currently disabled (when all fields are filled)
        if (this.disabled) {
            this.disabled = false;
            this.focus();
            // Clear other fields since we're editing the employee ID
            document.getElementById('ho_ten').value = '';
            document.getElementById('ngay_sinh').value = '';
            document.getElementById('so_dien_thoai').value = '';
            document.querySelector('input[name="vai_tro"][value="staff"]').checked = true;
            // Update the form state
            updateEmployeeIdFieldState();
        }
    });
});

// Form submission handler
if (registerForm) {
    registerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = {
            username: document.getElementById('username').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            ma_nhan_vien: document.getElementById('ma_nhan_vien').value || null,
            ho_ten: document.getElementById('ho_ten').value || null,
            ngay_sinh: document.getElementById('ngay_sinh').value || null,
            so_dien_thoai: document.getElementById('so_dien_thoai').value || null,
            vai_tro: document.querySelector('input[name="vai_tro"]:checked').value
        };
        
        console.log('Form submitted:', formData);
        // Here you would typically send the data to your backend
        alert('Đăng ký thành công!');
    });
}