<?php
require_once __DIR__ . '/../models/AdminModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/BookingModel.php';

class AdminController {
    private $adminModel;
    private $userModel;
    private $bookingModel;

    public function __construct() {
        $this->adminModel = new AdminModel();
        $this->userModel = new UserModel();
        $this->bookingModel = new BookingModel();
    }

    // Hiển thị trang đăng nhập admin
    public function login() {
        // Nếu đã đăng nhập admin, chuyển đến dashboard
        if (isset($_SESSION['admin_id'])) {
            header("Location: admin.php?action=dashboard");
            exit();
        }

        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            // Validation
            if (empty($username)) $errors[] = 'Tên đăng nhập không được để trống';
            if (empty($password)) $errors[] = 'Mật khẩu không được để trống';
            
            if (empty($errors)) {
                if ($this->adminModel->authenticate($username, $password)) {
                    // Tạo session admin
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    
                    $_SESSION['admin_id'] = $this->adminModel->id;
                    $_SESSION['admin_username'] = $this->adminModel->username;
                    $_SESSION['admin_fullname'] = $this->adminModel->fullname;
                    $_SESSION['admin_email'] = $this->adminModel->email;
                    $_SESSION['admin_role'] = $this->adminModel->role;
                    
                    header("Location: admin.php?action=dashboard");
                    exit();
                } else {
                    $errors[] = 'Tên đăng nhập hoặc mật khẩu không đúng';
                }
            }
        }
        
        include(__DIR__ . '/../views/admin/login.php');
    }

    // Dashboard admin
    public function dashboard() {
        // Kiểm tra đăng nhập admin
        if (!isset($_SESSION['admin_id'])) {
            header("Location: admin.php?action=login");
            exit();
        }

        // Lấy thống kê tổng quan
        $stats = $this->getDashboardStats();
        
        include(__DIR__ . '/../views/admin/dashboard.php');
    }

    // Đăng xuất admin
    public function logout() {
        // Xóa session admin
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_username']);
        unset($_SESSION['admin_fullname']);
        unset($_SESSION['admin_email']);
        unset($_SESSION['admin_role']);
        
        // Xóa cookie session
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        session_destroy();
        
        header("Location: admin.php?action=login");
        exit();
    }

    // Quản lý tài khoản khách hàng
    public function customers() {
        // Kiểm tra đăng nhập admin
        if (!isset($_SESSION['admin_id'])) {
            header("Location: admin.php?action=login");
            exit();
        }

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        // Lấy danh sách khách hàng
        $customers = $this->userModel->getAll($limit, $offset);
        $total_customers = $this->userModel->countAll();
        $total_pages = ceil($total_customers / $limit);
        
        include(__DIR__ . '/../views/admin/customers.php');
    }

    // Xem chi tiết khách hàng
    public function customerDetail($customer_id) {
        // Kiểm tra đăng nhập admin
        if (!isset($_SESSION['admin_id'])) {
            header("Location: admin.php?action=login");
            exit();
        }

        $customer = $this->userModel->getById($customer_id);
        if (!$customer) {
            header("Location: admin.php?action=customers&error=customer_not_found");
            exit();
        }

        // Lấy lịch sử đặt vé của khách hàng
        $bookings = $this->bookingModel->getByUserId($customer_id);
        
        include(__DIR__ . '/../views/admin/customer_detail.php');
    }

    // Xóa khách hàng
    public function deleteCustomer() {
        // Kiểm tra đăng nhập admin
        if (!isset($_SESSION['admin_id'])) {
            header("Location: admin.php?action=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customer_id = $_POST['customer_id'] ?? 0;
            
            if ($customer_id > 0) {
                if ($this->userModel->delete($customer_id)) {
                    header("Location: admin.php?action=customers&success=deleted");
                    exit();
                } else {
                    header("Location: admin.php?action=customers&error=delete_failed");
                    exit();
                }
            }
        }
        
        header("Location: admin.php?action=customers");
        exit();
    }

    // Quản lý ghe
    public function boats() {
        // Kiểm tra đăng nhập admin
        if (!isset($_SESSION['admin_id'])) {
            header("Location: admin.php?action=login");
            exit();
        }

        include(__DIR__ . '/../views/admin/boats.php');
    }

    // Quản lý chuyến đi
    public function trips() {
        // Kiểm tra đăng nhập admin
        if (!isset($_SESSION['admin_id'])) {
            header("Location: admin.php?action=login");
            exit();
        }

        include(__DIR__ . '/../views/admin/trips.php');
    }

    // Quản lý đặt vé
    public function bookings() {
        // Kiểm tra đăng nhập admin
        if (!isset($_SESSION['admin_id'])) {
            header("Location: admin.php?action=login");
            exit();
        }

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        // Lấy danh sách đặt vé
        $bookings = $this->bookingModel->getAll($limit, $offset);
        $total_bookings = $this->bookingModel->countAll();
        $total_pages = ceil($total_bookings / $limit);
        
        include(__DIR__ . '/../views/admin/bookings.php');
    }

    // Quản lý hóa đơn
    public function invoices() {
        // Kiểm tra đăng nhập admin
        if (!isset($_SESSION['admin_id'])) {
            header("Location: admin.php?action=login");
            exit();
        }

        include(__DIR__ . '/../views/admin/invoices.php');
    }

    // Thống kê báo cáo
    public function reports() {
        // Kiểm tra đăng nhập admin
        if (!isset($_SESSION['admin_id'])) {
            header("Location: admin.php?action=login");
            exit();
        }

        include(__DIR__ . '/../views/admin/reports.php');
    }

    // Cấu hình hệ thống
    public function settings() {
        // Kiểm tra đăng nhập admin
        if (!isset($_SESSION['admin_id'])) {
            header("Location: admin.php?action=login");
            exit();
        }

        include(__DIR__ . '/../views/admin/settings.php');
    }

    // Lấy thống kê dashboard
    private function getDashboardStats() {
        $stats = [];
        
        // Thống kê khách hàng
        $stats['total_customers'] = $this->userModel->countAll();
        $stats['new_customers_today'] = $this->userModel->countNewToday();
        
        // Thống kê đặt vé
        $stats['total_bookings'] = $this->bookingModel->countAll();
        $stats['bookings_today'] = $this->bookingModel->countToday();
        $stats['pending_bookings'] = $this->bookingModel->countByStatus('pending');
        $stats['confirmed_bookings'] = $this->bookingModel->countByStatus('confirmed');
        
        // Thống kê doanh thu
        $stats['total_revenue'] = $this->bookingModel->getTotalRevenue();
        $stats['revenue_today'] = $this->bookingModel->getRevenueToday();
        $stats['revenue_this_month'] = $this->bookingModel->getRevenueThisMonth();
        
        return $stats;
    }

    // Kiểm tra quyền admin
    public function checkAdminPermission() {
        if (!isset($_SESSION['admin_id'])) {
            return false;
        }
        return true;
    }

    // Kiểm tra quyền super admin
    public function checkSuperAdminPermission() {
        if (!isset($_SESSION['admin_id']) || $_SESSION['admin_role'] !== 'super_admin') {
            return false;
        }
        return true;
    }
}
?> 