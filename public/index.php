<?php

require_once __DIR__ . '/../app/controllers/AuthController.php';


$authController = new AuthController();

// Nếu không có action và không có view chuyển sang trang chủ
if (!isset($_GET['action']) && !isset($_GET['view'])) {
    include(__DIR__ . '/../app/views/home.php');
    exit;
}

// Xử lý action (login, logout, register)
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'login':
            $authController->login();
            break;
        case 'logout':
            $authController->logout();
            break;
        case 'register':
            $authController->register();
            break;
        case 'home':
            include(__DIR__ . '/../app/views/home.php');
            break;
        default:
            echo "<h2>404 - Không tìm thấy action</h2>";
            break;
    }

    exit; // Dừng nếu có action
}

// Xử lý view (như booking)
$view = $_GET['view'] ?? '';

switch ($view) {
    case 'booking':
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit;
        }
        include(__DIR__ . '/../app/views/booking.php');
        break;

    default:
        echo "<h2>404 - Không tìm thấy trang</h2>";
        break;
}
