document.addEventListener("DOMContentLoaded", function () {
  const thongKeData = [
    { thang: "01/2025", soHoaDon: 12, tongDoanhThu: "12.000.000" },
    { thang: "02/2025", soHoaDon: 9, tongDoanhThu: "10.500.000" },
    { thang: "03/2025", soHoaDon: 15, tongDoanhThu: "18.000.000" },
    { thang: "04/2025", soHoaDon: 7, tongDoanhThu: "8.200.000" },
    { thang: "05/2025", soHoaDon: 18, tongDoanhThu: "22.500.000" }
  ];

  const tableBody = document.getElementById("thongKeTableBody");

  thongKeData.forEach(entry => {
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${entry.thang}</td>
      <td>${entry.soHoaDon}</td>
      <td>${entry.tongDoanhThu}</td>
    `;
    tableBody.appendChild(row);
  });
});
