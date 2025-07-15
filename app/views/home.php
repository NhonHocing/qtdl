<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>Chào mừng đến với hệ thống</h1>
            <div class="user-info">
                <p>Xin chào, <span class="username"><?php echo htmlspecialchars($_SESSION['username']); ?></span></p>
                <a href="index.php?action=logout" class="logout-btn">Đăng xuất</a>
            </div>
        </header>
        
        <main class="content">
            <h2>Bạn đã đăng nhập thành công!</h2>
            <p>Đây là trang chủ sau khi đăng nhập. Bạn có thể thêm nội dung của mình vào đây.</p>
        </main>
        
        <footer class="footer">
            <p>&copy; <?php echo date('Y'); ?> - Hệ thống MVC PHP</p>
        </footer>
    </div>
</body>
</html> 