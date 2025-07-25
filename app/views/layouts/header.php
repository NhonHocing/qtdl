<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Hệ thống đặt vé' ?></title>
    <link rel="stylesheet" href="public/css/style_home.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Segoe+UI&display=swap">
    <style>
        header {
            background-color: #e65100;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        nav a {
            color: white;
            margin-left: 20px;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<header>
    <h1>Chợ nổi Cái Răng</h1>
    <nav>
        <a href="index.php">Trang chủ</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="index.php?view=booking">Đặt vé</a>
            <a href="index.php?action=logout">Đăng xuất</a>
        <?php else: ?>
            <a href="index.php?action=login">Đăng nhập</a>
            <a href="index.php?action=register">Đăng ký</a>
        <?php endif; ?>
    </nav>
</header>
