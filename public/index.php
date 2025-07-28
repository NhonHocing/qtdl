<?php
// Cấu hình hiển thị lỗi
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/CustomerController.php';
require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../app/controllers/BookingController.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';

$authController = new AuthController();
$customerController = new CustomerController();
$homeController = new HomeController();
$bookingController = new BookingController();
$adminController = new AdminController();

// Lấy thông tin controller và action từ URL
$controller = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

// Chuyển về trang chủ nếu không có tham số
if (!isset($_GET['controller']) && !isset($_GET['action'])) {
    $homeController->index();
    exit;
}

// Xử lý điều hướng theo controller
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
        
    case 'booking':
        switch ($action) {
            case 'book_ticket':
                $bookingController->bookTicket();
                break;
            case 'cancel':
                $bookingController->cancelBooking();
                break;
            case 'history':
                $bookingController->getBookingHistory();
                break;
            default:
                echo "<h2>404 - Không tìm thấy action</h2>";
                break;
        }
        break;
        
    case 'admin':
        switch ($action) {
            case 'dashboard':
                $adminController->dashboard();
                break;
            case 'customers':
                $adminController->customers();
                break;
            case 'bookings':
                $adminController->bookings();
                break;
            case 'boats':
                $adminController->boats();
                break;
            case 'trips':
                $adminController->trips();
                break;
            case 'login':
                $adminController->login();
                break;
            case 'logout':
                $adminController->logout();
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
