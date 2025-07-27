<?php
session_start();

require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/CustomerController.php';
require_once __DIR__ . '/../app/controllers/HomeController.php';

$authController = new AuthController();
$customerController = new CustomerController();
$homeController = new HomeController();

// Lấy controller và action từ URL
$controller = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

// Nếu không có controller và action, chuyển về trang chủ
if (!isset($_GET['controller']) && !isset($_GET['action'])) {
    $homeController->index();
    exit;
}

// Điều hướng theo controller được chọn
switch ($controller) {
    case 'auth':
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
            default:
                echo "<h2>404 - Không tìm thấy action</h2>";
                break;
        }
        break;
        
    case 'customer':
        switch ($action) {
            case 'home':
                $customerController->home();
                break;
            case 'booking':
                $customerController->booking();
                break;
            case 'booking_history':
                $customerController->bookingHistory();
                break;
            case 'profile':
                $customerController->profile();
                break;
            default:
                echo "<h2>404 - Không tìm thấy action</h2>";
                break;
        }
        break;
        
    case 'home':
        $homeController->index();
        break;
        
    default:
        echo "<h2>404 - Không tìm thấy controller</h2>";
        break;
}
?>
