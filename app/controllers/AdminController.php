<?php
require_once __DIR__ . '/../models/AdminModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/BookingModel.php';
require_once __DIR__ . '/../models/RouteModel.php';
require_once __DIR__ . '/../config/database.php';

class AdminController {
    private $adminModel;
    private $userModel;
    private $bookingModel;
    private $routeModel;

    public function __construct() {
        $this->adminModel = new AdminModel();
        $this->userModel = new UserModel();
        $this->bookingModel = new BookingModel();
        $this->routeModel = new RouteModel();
    }

    // Hiển thị trang đăng nhập admin
    public function login() {
        // Nếu đã đăng nhập admin, chuyển đến dashboard
        if (isset($_SESSION['admin_id'])) {
            header("Location: index.php?controller=admin&action=dashboard");
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
                    
                    header("Location: index.php?controller=admin&action=dashboard");
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
            header("Location: index.php?controller=admin&action=login");
            exit();
        }

        // Lấy thống kê tổng quan
        $stats = $this->getDashboardStats();
        
        // Lấy danh sách đặt vé gần đây
        $recentBookings = $this->bookingModel->getRecentBookings(5);
        
        // Truyền dữ liệu vào view
        $totalBookings = $stats['total_bookings'] ?? 0;
        $totalUsers = $stats['total_customers'] ?? 0;
        $totalRevenue = $stats['revenue_this_month'] ?? 0;
        $pendingBookings = $stats['pending_bookings'] ?? 0;
        $conn = $this->bookingModel->getConnection();
        
        include(__DIR__ . '/../views/admin/dashboard.php');
    }

    // Đăng xuất admin
    public function logout() {
        // Xóa tất cả session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Clear all session variables
        $_SESSION = [];
        
        // Xóa cookie session
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Destroy session
        session_destroy();
        
        // Chuyển về trang đăng nhập
        header("Location: index.php?controller=admin&action=login");
        exit();
    }

    // Quản lý khách hàng
    public function customers() {
        // Kiểm tra đăng nhập admin
        if (!isset($_SESSION['admin_id'])) {
            header("Location: index.php?controller=admin&action=login");
            exit();
        }

        // Lấy danh sách khách hàng từ database
        try {
            // Kiểm tra xem Database class có tồn tại không
            if (!class_exists('Database')) {
                require_once __DIR__ . '/../config/database.php';
            }
            
            $database = new Database();
            $conn = $database->getConnection();
            
            // Lấy tất cả users có role = 'customer'
            $query = "SELECT id, username, fullname, email, phone, status, created_at, 
                             (SELECT COUNT(*) FROM bookings WHERE bookings.user_id = users.id) as total_bookings,
                             (SELECT SUM(total_price) FROM bookings WHERE bookings.user_id = users.id AND status = 'confirmed') as total_spent
                      FROM users 
                      WHERE role = 'customer' 
                      ORDER BY created_at DESC";
            
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Thống kê
            $statsQuery = "SELECT 
                            COUNT(*) as total_customers,
                            COUNT(CASE WHEN status = 'active' THEN 1 END) as active_customers,
                            COUNT(CASE WHEN created_at >= CURRENT_DATE - INTERVAL '30 days' THEN 1 END) as new_customers
                          FROM users 
                          WHERE role = 'customer'";
            
            $statsStmt = $conn->prepare($statsQuery);
            $statsStmt->execute();
            $stats = $statsStmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            $customers = [];
            $stats = [
                'total_customers' => 0,
                'active_customers' => 0,
                'new_customers' => 0
            ];
        }
        
        include(__DIR__ . '/../views/admin/customers.php');
    }

    // Quản lý ghe
    public function boats() {
        // Kiểm tra đăng nhập admin
        if (!isset($_SESSION['admin_id'])) {
            header("Location: index.php?controller=admin&action=login");
            exit();
        }

        include(__DIR__ . '/../views/admin/boats.php');
    }

    // Quản lý chuyến đi
    public function trips() {
        // Kiểm tra đăng nhập admin
        if (!isset($_SESSION['admin_id'])) {
            header("Location: index.php?controller=admin&action=login");
            exit();
        }

        include(__DIR__ . '/../views/admin/trips.php');
    }

    // Quản lý đặt vé
    public function bookings() {
        // Kiểm tra đăng nhập admin
        if (!isset($_SESSION['admin_id'])) {
            header("Location: index.php?controller=admin&action=login");
            exit();
        }

        // Lấy danh sách đặt vé
        $bookings = $this->bookingModel->getAll(1000, 0);
        
        include(__DIR__ . '/../views/admin/bookings.php');
    }

    // Lấy thống kê dashboard
    private function getDashboardStats() {
        try {
            $conn = $this->bookingModel->getConnection();
            
            // Tổng số đặt vé
            $stmt = $conn->prepare("SELECT COUNT(*) as total FROM bookings");
            $stmt->execute();
            $totalBookings = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Tổng số khách hàng
            $stmt = $conn->prepare("SELECT COUNT(*) as total FROM users WHERE role = 'customer'");
            $stmt->execute();
            $totalCustomers = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Doanh thu tháng này
            $stmt = $conn->prepare("SELECT COALESCE(SUM(total_price), 0) as revenue FROM bookings WHERE status = 'confirmed' AND created_at >= DATE_TRUNC('month', CURRENT_DATE)");
            $stmt->execute();
            $revenueThisMonth = $stmt->fetch(PDO::FETCH_ASSOC)['revenue'];
            
            // Đặt vé chờ xử lý
            $stmt = $conn->prepare("SELECT COUNT(*) as total FROM bookings WHERE status = 'pending'");
            $stmt->execute();
            $pendingBookings = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            return [
                'total_bookings' => $totalBookings,
                'total_customers' => $totalCustomers,
                'revenue_this_month' => $revenueThisMonth,
                'pending_bookings' => $pendingBookings
            ];
            
        } catch (Exception $e) {
            return [
                'total_bookings' => 0,
                'total_customers' => 0,
                'revenue_this_month' => 0,
                'pending_bookings' => 0
            ];
        }
    }
}
?> 