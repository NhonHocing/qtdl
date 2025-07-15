// Sample employee data - in a real app, this would come from an API
let employees = [
    { id: 'NV001', name: 'Nguyễn Văn A', dob: '1990-01-01', phone: '0912345678', role: 'admin' },
    { id: 'NV002', name: 'Trần Thị B', dob: '1992-05-15', phone: '0912345679', role: 'staff' },
    { id: 'NV003', name: 'Lê Văn C', dob: '1988-11-20', phone: '0912345680', role: 'staff' }
];
console.log(employees);
// fetch('http://localhost:8000/api/categories/staffs/')
//     .then(response => {
//         console.log(response);
//         return response;
//     })
//     .then(data => {
//         employees = data;
//         console.log(employees);
//     })
//     .catch(error => {
//         console.error('Error fetching employees:', error);
//     });
    fetch('http://localhost:8000/api/categories/staffs/') // Thay bằng URL thực tế của bạn
    .then(response => {
      if (!response.ok) {
        throw new Error('Lỗi mạng: ' + response.status);
      }
      return response.json(); // Parse JSON từ response
    })
    .then(data => {
      console.log('Danh sách nhân viên:', data);
      employees = data;
      console.log(employees);
  
      // Ví dụ: in từng nhân viên
      data.forEach(nv => {
        console.log(`${nv.ma_nhan_vien} - ${nv.ho_ten} (${nv.role})`);
      });
    })
    .catch(error => {
      console.error('Lỗi khi gọi API:', error);
    });

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

// API Base URL
const API_BASE_URL = 'http://localhost:8000/api';

// Show error message
function showError(elementId, message) {
    const errorElement = document.getElementById(elementId);
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }
}

// Clear error message
function clearError(elementId) {
    const errorElement = document.getElementById(elementId);
    if (errorElement) {
        errorElement.textContent = '';
        errorElement.style.display = 'none';
    }
}

// Handle registration
async function handleRegister(formData) {
    try {
        // Prepare request body based on whether ma_nhan_vien is provided
        const requestBody = {
            username: formData.username,
            email: formData.email,
            password: formData.password
        };

        // Check if we have ma_nhan_vien (case 1) or need full staff details (case 2)
        if (formData.ma_nhan_vien) {
            requestBody.ma_nhan_vien = formData.ma_nhan_vien;
        } else {
            // Only include staff details if ma_nhan_vien is not provided
            requestBody.staff = {
                ho_ten: formData.ho_ten,
                ngay_sinh: formData.ngay_sinh,
                so_dien_thoai: formData.so_dien_thoai,
                role: formData.vai_tro || 'staff' // Default to 'staff' if not provided
            };
        }

        const response = await fetch(`${API_BASE_URL}/auth/register/`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(requestBody)
        });

        const data = await response.json();

        if (response.ok) {
            // Registration successful
            alert('Đăng ký tài khoản thành công!');
            // Redirect to login or dashboard
            container.classList.remove('active');
            registerForm.reset();
        } else {
            // Handle errors
            if (data.errors) {
                Object.entries(data.errors).forEach(([field, messages]) => {
                    showError(`${field}-error`, `${field}: ${messages.join(', ')}`);
                });
            } else {
                showError('register-error', 'Đăng ký thất bại. Vui lòng thử lại.');
            }
        }
    } catch (error) {
        console.error('Registration error:', error);
        showError('register-error', 'Có lỗi xảy ra khi đăng ký. Vui lòng thử lại sau.');
    }
}

// Handle login
async function handleLogin(formData) {
    try {
        const response = await fetch(`${API_BASE_URL}/auth/login/`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                username: formData.username,
                password: formData.password
            })
        });

        const data = await response.json();
        console.log(data);
        

        if (response.ok) {
            // Login successful
            alert(data.message || 'Đăng nhập thành công!');
            // Store user data in localStorage or sessionStorage
            localStorage.setItem('user', JSON.stringify({
                id: data.id,
                username: data.username,
                email: data.email,
                role: data.role,
                ma_nhan_vien: data.ma_nhan_vien
            }));
            // Redirect to dashboard or home page
            window.location.href = './Dashboard.html';
        } else {
            // Handle login error
            const errorMessage = data.non_field_errors ? data.non_field_errors[0] : 'Đăng nhập thất bại. Vui lòng kiểm tra lại thông tin.';
            showError('login-error', errorMessage);
        }
    } catch (error) {
        console.error('Login error:', error);
        showError('login-error', 'Có lỗi xảy ra khi đăng nhập. Vui lòng thử lại sau.');
    }
}


registerForm.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Clear previous errors
    clearError('register-error');
    
    const formData = {
        username: document.getElementById('username').value.trim(),
        email: document.getElementById('email').value.trim(),
        password: document.getElementById('password').value,
        ma_nhan_vien: document.getElementById('ma_nhan_vien').value.trim() || null,
        ho_ten: document.getElementById('ho_ten').value.trim(),
        ngay_sinh: document.getElementById('ngay_sinh').value,
        so_dien_thoai: document.getElementById('so_dien_thoai').value.trim(),
        vai_tro: document.querySelector('input[name="vai_tro"]:checked').value
    };
    
    // Basic validation
    if (!formData.username || !formData.email || !formData.password || !formData.ho_ten || 
        !formData.ngay_sinh || !formData.so_dien_thoai) {
        showError('register-error', 'Vui lòng điền đầy đủ thông tin.');
        return;
    }
    
    await handleRegister(formData);
});
    
// Handle login form submission
const loginForm = document.getElementById('loginForm');
if (loginForm) {
    loginForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Clear previous errors
        clearError('login-error');
        
        const formData = {
            username: document.getElementById('login-username').value.trim(),
            password: document.getElementById('login-password').value
        };
        console.log(formData)
        // Basic validation
        if (!formData.username || !formData.password) {
            showError('login-error', 'Vui lòng điền đầy đủ tên đăng nhập và mật khẩu.');
            return;
        }
        try {
            await handleLogin(formData);
        } catch (error) {
            showError('login-error', 'Có lỗi xảy ra khi đăng nhập. Vui lòng thử lập sau.');
        }
    });
}
