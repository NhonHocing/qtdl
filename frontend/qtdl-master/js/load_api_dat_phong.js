async function loadRents() {
  const cacheKey = "rents";

  const cached = localStorage.getItem(cacheKey);
  if (cached) {
    return JSON.parse(cached);
  }

  try {
    const res = await fetch("http://localhost:8000/api/categories/rents/");
    const data = await res.json();
    localStorage.setItem(cacheKey, JSON.stringify(data));
    return data;
  } catch (error) {
    console.error("Không thể tải danh sách đặt phòng:", error);
    return [];
  }
}

// Load danh sách đặt phòng từ localStorage hoặc API
async function loadRents() {
  const cacheKey = "rents";

  // Kiểm tra nếu có cache
  const cached = localStorage.getItem(cacheKey);
  if (cached) {
    console.log("Đang sử dụng dữ liệu từ localStorage");
    return JSON.parse(cached);
  }

  // Nếu không có cache → gọi API
  try {
    const res = await fetch("http://localhost:8000/api/categories/rents/");
    if (!res.ok) throw new Error("Không thể lấy dữ liệu");
    const data = await res.json();

    // Lưu cache
    localStorage.setItem(cacheKey, JSON.stringify(data));
    return data;
  } catch (error) {
    console.error("Lỗi khi gọi API rent:", error);
    return [];
  }
}

// Hiển thị danh sách ra bảng
function renderRents(rents) {
  const tbody = document.getElementById("bookingList");
  tbody.innerHTML = "";

  if (rents.length === 0) {
    tbody.innerHTML = `<tr><td colspan="8" class="text-center"><p>Không có dữ liệu đặt phòng</p></td></tr>`;
    return;
  }

  rents.forEach((rent, index) => {
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${index + 1}</td>
      <td>${rent.ma_khach_hang || "—"}</td>
      <td>${rent.ma_phong || "—"}</td>
      <td>${rent.ngay_thue}</td>
      <td>${rent.ngay_nhan}</td>
      <td>${rent.ngay_tra}</td>
      <td>${rent.trang_thai}</td>
      <td class="actions">
        <button class="btn btn-sm btn-warning" disabled>Sửa</button>
        <button class="btn btn-sm btn-danger" disabled>Xóa</button>
      </td>
    `;
    tbody.appendChild(row);
  });
}

// Gọi khi trang tải
document.addEventListener("DOMContentLoaded", async () => {
  const rents = await loadRents();
  renderRents(rents);
});

// Nút "Làm mới danh sách" nếu có
const refreshBtn = document.getElementById("btnRefreshRents");
if (refreshBtn) {
  refreshBtn.addEventListener("click", async () => {
    localStorage.removeItem("rents");
    const rents = await loadRents();
    renderRents(rents);
  });
}