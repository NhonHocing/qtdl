// // Sample data - In a real app, this would come from an API
// let customers=[];
// let rooms=[];
// let roomTypes=[];
// let services=[];
// let serviceUsages=[];
// let staffs=[];

// fetch("http://localhost:8000/api/categories/staffs/")
//   .then(res => res.json())
//   .then(data => {
//    staffs =data;
//    console.log(staffs);
//     });

// fetch("http://localhost:8000/api/categories/service-usages/")
//   .then(res => res.json())
//   .then(data => {
//    serviceUsages =data;
//     });

// fetch("http://localhost:8000/api/categories/services/")
//   .then(res => res.json())
//   .then(data => {
//    services =data;
//     });

// fetch("http://localhost:8000/api/categories/room-types/")
//   .then(res => res.json())
//   .then(data => {
//    roomTypes =data;
//     });

// fetch("http://localhost:8000/api/categories/rooms/")
//   .then(res => res.json())
//   .then(data => {
//    rooms =data;
//     });

// fetch("http://localhost:8000/api/categories/customers/")
//   .then(res => res.json())
//   .then(data => {
//    customers =data;
//     });
 
// console.log(staffs);
// console.log(services);
// console.log(serviceUsages);
// console.log(roomTypes);
// console.log(rooms);
// console.log(customers);

// Helper function to check if a room is available for booking
function isRoomAvailable(roomId, checkInDate, checkOutDate, excludeBookingIndex = -1) {
  const checkIn = new Date(checkInDate);
  const checkOut = new Date(checkOutDate);
  
  return !data.some((booking, index) => {
    if (index === excludeBookingIndex) return false;
    if (booking.maPhong !== roomId) return false;
    
    const existingCheckIn = new Date(booking.ngayNhan);
    const existingCheckOut = new Date(booking.ngayTra);
    
    return (
      (checkIn >= existingCheckIn && checkIn < existingCheckOut) ||
      (checkOut > existingCheckIn && checkOut <= existingCheckOut) ||
      (checkIn <= existingCheckIn && checkOut >= existingCheckOut)
    );
  });
}

const form = document.getElementById('bookingForm');
const bookingList = document.getElementById('bookingList');
let data = [];

// user local
// id: data.id,
//                 username: data.username,
//                 email: data.email,
//                 role: data.role,
//                 ma_nhan_vien: data.ma_nhan_vien

function get_current_staff(){
  staff = JSON.parse(localStorage.getItem('user'));
  return staff;
}

// Initialize the form
function initForm(customers, rooms) {
  console.log("init form")
  // Populate customer dropdown
  staff = get_current_staff();
  const maNV = document.getElementById('maNV');
  maNV.value = staff.ma_nhan_vien;

  const maKHSelect = document.getElementById('maKH');
  customers.forEach(customer => {
    const option = document.createElement('option');
    option.value = customer.ma_khach_hang;
    option.textContent = `${customer.ma_khach_hang} - ${customer.ten_khach_hang} - ${customer.so_dien_thoai}`;
    maKHSelect.appendChild(option);
  });

  // Populate room dropdown
const maPhongSelect = document.getElementById('maPhong');
rooms.forEach(room => {
  const option = document.createElement('option');
  option.value = room.ma_phong;
  const floor = "Tầng " + room.ma_phong[1];
  option.textContent = `${room.ma_phong} - ${room.so_phong} - ${floor}`;
  option.dataset.number = room.number;
  option.dataset.floor = room.floor;
  maPhongSelect.appendChild(option);
});

  
  // Set default dates
  const today = new Date().toISOString().split('T')[0];
  document.getElementById('ngayThue').value = today;
  document.getElementById('ngayNhan').value = today;
  
  // Set default status
  document.getElementById('trangThai').value = 'Đã đặt';
}

// Form validation
function validateForm() {
  const ngayThue = new Date(document.getElementById('ngayThue').value);
  const ngayNhan = new Date(document.getElementById('ngayNhan').value);
  const ngayTra = new Date(document.getElementById('ngayTra').value);
  
  if (ngayThue > ngayNhan) {
    alert('Ngày thuê không được sau ngày nhận.');
    return false;
  }
  
  if (ngayTra < ngayNhan) {
    alert('Ngày trả phải sau hoặc bằng ngày nhận.');
    return false;
  }
  
  return true;
}

async function submit_form(data) {
  try {
    const response = await fetch('http://localhost:8000/api/bookings/', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(data),
    });
} catch (error) {
  alert('Không thể đặt phòng'+error);
  console.error(error);
}
}

// Form submission
form.addEventListener('submit', async function (e) {
  e.preventDefault();
  
  if (!validateForm()) {
    return;
  }
  const maNV = document.getElementById('maNV').value;
  const maKH = document.getElementById('maKH').value;
  const maPhong = document.getElementById('maPhong').value;
  const ngayThue = document.getElementById('ngayThue').value;
  const ngayNhan = document.getElementById('ngayNhan').value;
  const ngayTra = document.getElementById('ngayTra').value;
  const editingIndex = document.getElementById('editingIndex').value;
  const isEditing = editingIndex !== '';

  // Check room availability
  if (!isRoomAvailable(maPhong, ngayNhan, ngayTra, isEditing ? editingIndex : -1)) {
    alert('Phòng đã được đặt trong khoảng thời gian này. Vui lòng chọn phòng hoặc ngày khác.');
    return;
  }

  const booking = {
    ma_nhan_vien: maNV,
    ma_khach_hang: maKH,
    ma_phong: maPhong,
    ngay_thue: ngayThue, // Keep original ngayThue when editing
    ngay_nhan: ngayNhan,
    ngay_tra: ngayTra,
    trang_thai: 'Đã đặt' // Keep original status when editing
  };

  if (isEditing) {
    data[editingIndex] = booking;
    document.getElementById('editingIndex').value = '';
  } else {
    data.push(booking);
  }
  await submit_form(booking);

  form.reset();
      let customers = await loadData('customers', 'http://localhost:8000/api/categories/customers/');
    let rooms = await loadData('rooms', 'http://localhost:8000/api/categories/rooms/');
    initForm(customers, rooms);
  renderTable();
});

async function loadData(key, apiUrl, fallbackData = []) {

  try {
    const response = await fetch(apiUrl);
    if (!response.ok) throw new Error(`API ${key} lỗi`);
    const data = await response.json();
    console.log("init form")
    console.log("form", data)
    return data;
  } catch (err) {
    console.error(`Không thể tải ${key} từ API. Dùng dữ liệu mẫu.`, err);
    return fallbackData;
  }
}

// {
//     "ma_thue": "TH0001",
//     "ma_khach_hang": "KH007",
//     "ma_phong": "F3-107",
//     "ngay_thue": "2025-01-21",
//     "ngay_nhan": "2025-01-21",
//     "ngay_tra": "2025-01-26",
//     "trang_thai": "Đã trả",
//     "ma_nhan_vien": "NV005"
// }

async function renderTable() {
  api = "http://localhost:8000/api/bookings/";
  data = await loadData("bookings", api);
  console.log(data);
  bookingList.innerHTML = '';

  data.forEach((item, index) => {
    const row = document.createElement('tr');
    const today = new Date().toISOString().split('T')[0];
    const isCheckInDisabled = item.trangThai !== 'Đã đặt' || new Date(item.ngayNhan) > new Date(today);
    const isEditDisabled = item.trangThai !== 'Đang ở'; // Only allow editing for 'Đang ở' status

    row.innerHTML = `
      <td>${index + 1}</td>
      <td>${item.ma_khach_hang}</td>
      <td>${item.ma_phong}</td>
      <td>${item.ngay_thue}</td>
      <td>${item.ngay_nhan}</td>
      <td>${item.ngay_tra}</td>
      <td>${item.trang_thai}</td>
      <td class="actions">
        <button class="btn-checkin" onclick="checkIn(${index})" ${isCheckInDisabled ? 'disabled' : ''}>
          Check-in
        </button>
        <button class="btn-edit" onclick="editBooking(${index})" ${isEditDisabled ? 'disabled' : ''}>
          Sửa
        </button>
        <button class="btn-delete" onclick="deleteBooking(${index})" ${isEditDisabled ? 'disabled' : ''}>
          Xóa
        </button>
      </td>
    `;

    bookingList.appendChild(row);
  });
}

function editBooking(index) {
  const item = data[index];
  document.getElementById('maKH').value = item.maKH;
  // Don't allow changing room when editing
  document.getElementById('maPhong').disabled = true;
  document.getElementById('ngayNhan').disabled = true;
  document.getElementById('editingIndex').value = index;
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function deleteBooking(index) {
  const booking = data[index];
  if (booking.trangThai === 'Đã trả' || 
      confirm('Bạn có chắc chắn muốn xóa đơn đặt phòng này? Thao tác này không thể hoàn tác.')) {
    data.splice(index, 1);
    renderTable();
  }
}

// Check-in function
function checkIn(index) {
  if (data[index].trangThai === 'Đã đặt') {
    data[index].trangThai = 'Đang ở';
    renderTable();
  }
}

// Remove expired bookings
function removeExpiredBookings() {
  const today = new Date();
  today.setHours(0, 0, 0, 0);
  
  const expiredBookings = data.filter(booking => {
    const checkInDate = new Date(booking.ngayNhan);
    return booking.trangThai === 'Đã đặt' && checkInDate < today;
  });
  
  if (expiredBookings.length === 0) {
    alert('Không có đơn đặt phòng nào quá hạn cần xóa.');
    return;
  }
  
  if (confirm(`Bạn có chắc chắn muốn xóa ${expiredBookings.length} đơn đặt phòng đã quá hạn?`)) {
    data = data.filter(booking => booking.trangThai !== 'Đã đặt' || new Date(booking.ngayNhan) >= today);
    renderTable();
    alert(`Đã xóa ${expiredBookings.length} đơn đặt phòng quá hạn.`);
  }
}

// Initialize the form when the page loads
async function init() {
  document.addEventListener('DOMContentLoaded', async function() {
    let customers = await loadData('customers', 'http://localhost:8000/api/categories/customers/');
    let rooms = await loadData('rooms', 'http://localhost:8000/api/categories/rooms/');
  initForm(customers, rooms);
  renderTable();
  console.log("a")
  
  // Add cancel button handler
  document.getElementById('btnHuy').addEventListener('click', async function() {
    form.reset();
    document.getElementById('editingIndex').value = '';
    document.getElementById('maPhong').disabled = false;
    document.getElementById('ngayNhan').disabled = false;
    let customers = await loadData('customers', 'http://localhost:8000/api/categories/customers/');
    let rooms = await loadData('rooms', 'http://localhost:8000/api/categories/rooms/');
    initForm(customers, rooms);
  });
  
  // Add date change validators
  document.getElementById('ngayThue').addEventListener('change', validateDates);
  document.getElementById('ngayNhan').addEventListener('change', validateDates);
  document.getElementById('ngayTra').addEventListener('change', validateDates);
  
  // Add remove expired bookings handler
  document.getElementById('btnRemoveExpired').addEventListener('click', removeExpiredBookings);
});
}


// Date validation helper
function validateDates() {
  const ngayThue = new Date(document.getElementById('ngayThue').value);
  const ngayNhan = new Date(document.getElementById('ngayNhan').value);
  const ngayTra = new Date(document.getElementById('ngayTra').value);
  
  if (ngayThue > ngayNhan) {
    document.getElementById('ngayNhan').setCustomValidity('Ngày nhận phải sau hoặc bằng ngày thuê');
  } else {
    document.getElementById('ngayNhan').setCustomValidity('');
  }
  
  if (ngayTra < ngayNhan) {
    document.getElementById('ngayTra').setCustomValidity('Ngày trả phải sau hoặc bằng ngày nhận');
  } else {
    document.getElementById('ngayTra').setCustomValidity('');
  }
}

init();