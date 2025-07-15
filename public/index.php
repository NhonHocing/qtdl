<?php
// Bắt đầu session
session_start();

// Require các file cần thiết
require_once __DIR__ . '/../app/controllers/Auth.php';


// Xác định action từ query string
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Khởi tạo controller
$authController = new AuthController();

// Kiểm tra người dùng đã đăng nhập chưa
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Điều hướng dựa trên action
switch($action) {
    case 'register':
        $authController->register();
        break;
    
    case 'login':
        $authController->login();
        break;
    
    case 'logout':
        $authController->logout();
        break;
    
    case 'home':
        // Kiểm tra nếu chưa đăng nhập thì chuyển hướng đến trang đăng nhập
        if(!isLoggedIn()) {
            header("Location: index.php?action=login");
            exit();
        }
        
        // Hiển thị trang chủ
        include __DIR__ . '/../app/views/home.php';
        break;
    
    default:
        // Nếu đã đăng nhập, chuyển hướng đến trang chủ
        if(isLoggedIn()) {
            header("Location: index.php?action=home");
            exit();
        } else {
            // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
            header("Location: index.php?action=login");
            exit();
        }
        break;
}
?> 