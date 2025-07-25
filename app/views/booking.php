<?php
require_once __DIR__ . '/../config/database.php';

$db = new Database();
$conn = $db->getConnection();

// Xử lý khi người dùng gửi form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ho_ten = $_POST['ho_ten'];
    $email = $_POST['email'];
    $sdt = $_POST['sdt'];
    $so_luong = $_POST['so_luong'];
    $id_tour = $_POST['id_tour'];

    $stmt = $conn->prepare("INSERT INTO ve (id_tour, ho_ten, email, sdt, so_luong) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$id_tour, $ho_ten, $email, $sdt, $so_luong]);

    echo "<p>✅ Đặt vé thành công! Cảm ơn bạn, $ho_ten.</p>";
}

// Lấy danh sách tour để hiển thị
$tour_stmt = $conn->query("SELECT id, ten_tour FROM tour");
$tours = $tour_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Đặt vé tàu du lịch</h2>
<link rel="stylesheet" href="/css/dat_ve.css">
<form method="post">
    <label>Họ tên:</label><br>
    <input type="text" name="ho_ten" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email"><br><br>

    <label>SĐT:</label><br>
    <input type="text" name="sdt"><br><br>

    <label>Số lượng vé:</label><br>
    <input type="number" name="so_luong" min="1" required><br><br>

    <label>Chọn tour:</label><br>
    <select name="id_tour" required>
        <?php foreach ($tours as $tour): ?>
            <option value="<?= $tour['id'] ?>"><?= htmlspecialchars($tour['ten_tour']) ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <button type="submit">Đặt vé</button>
</form>
