const form = document.getElementById("form-hoa-don");
const tableBody = document.getElementById("hoa-don-body");
let hoaDons = [];
let editIndex = -1; // Biến kiểm tra đang sửa hay thêm mới

form.addEventListener("submit", function (e) {
  e.preventDefault();
  const ma = document.getElementById("ma").value.trim();
  const ten = document.getElementById("ten").value.trim();
  const phong = document.getElementById("phong").value.trim();
  const tong = document.getElementById("tong").value.trim();

  if (ma && ten && phong && tong) {
    const hoaDon = { ma, ten, phong, tong };

    if (editIndex === -1) {
      // THÊM mới
      hoaDons.push(hoaDon);
    } else {
      // CẬP NHẬT
      hoaDons[editIndex] = hoaDon;
      editIndex = -1;
      form.querySelector("button").textContent = "Thêm";
    }

    renderTable();
    form.reset();
  }
});

function renderTable() {
  tableBody.innerHTML = "";
  hoaDons.forEach((item, index) => {
    const row = document.createElement("tr");

    row.innerHTML = `
      <td>${item.ma}</td>
      <td>${item.ten}</td>
      <td>${item.phong}</td>
      <td>${item.tong} VND</td>
      <td>
        <button class="edit" onclick="editHD(${index})">Sửa</button>
        <button class="delete" onclick="deleteHD(${index})">Xóa</button>
      </td>
    `;

    tableBody.appendChild(row);
  });
}

function deleteHD(index) {
  if (confirm("Bạn chắc chắn muốn xóa hóa đơn này?")) {
    hoaDons.splice(index, 1);
    renderTable();
  }
}

function editHD(index) {
  const hd = hoaDons[index];
  document.getElementById("ma").value = hd.ma;
  document.getElementById("ten").value = hd.ten;
  document.getElementById("phong").value = hd.phong;
  document.getElementById("tong").value = hd.tong;

  editIndex = index;
  form.querySelector("button").textContent = "Cập nhật";
}
