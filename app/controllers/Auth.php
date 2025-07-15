<?php
require_once __DIR__ . '/../models/UserModel.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
// include __DIR__ . '/../views/login.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }
    
    public function register() {
        // Nếu form đăng ký được submit
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $username = isset($_POST['username']) ? $_POST['username'] : "";
            $password = isset($_POST['password']) ? $_POST['password'] : "";
            $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : "";
            $address = isset($_POST['address']) ? $_POST['address'] : "";
            $phone = isset($_POST['phone']) ? $_POST['phone'] : "";   
            // Mật khẩu xác nhận 
            $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : "";
            $errors = [];
            
            // Validate dữ liệu
            if(empty($username)) {
                $errors[] = "Tên đăng nhập không được để trống.";
            }
            
            if(empty($password)) {
                $errors[] = "Mật khẩu không được để trống.";
            }

            if(empty($fullname)) {
                $errors[] = "Họ tên không được để trống.";
            }

            if(empty($address)) {
                $errors[] = "Địa chỉ không được để trống.";
            }

            if(empty($phone)) {
                $errors[] = "Số điện thoại không được để trống.";
            } elseif(!preg_match('/^\d{10,11}$/', $phone)) {
                $errors[] = "Số điện thoại không hợp lệ.";
            }
            
            if($password !== $confirm_password) {
                $errors[] = "Mật khẩu không khớp.";
            }
            
            // Kiểm tra xem username đã tồn tại chưa
            $this->userModel->username = $username;
            if($this->userModel->usernameExists()) {
                $errors[] = "Tên đăng nhập đã tồn tại.";
            }
            
            // Nếu không có lỗi, tiến hành đăng ký
            if(empty($errors)) {
                $this->userModel->username = $username;
                $this->userModel->password = $password;
                $this->userModel->fullname = $fullname;
                $this->userModel->address = $address;
                $this->userModel->phone = $phone;

                if($this->userModel->create()) {
                    header("Location: index.php?action=login&success=1");
                    exit();
                } else {
                    $errors[] = "Đăng ký thất bại. Vui lòng thử lại.";
                }
            }

            
            // Hiển thị lại form đăng ký với thông báo lỗi
            include __DIR__ . '/../views/register.php';
        } else {
            // Hiển thị form đăng ký
            include __DIR__ . '/../views/register.php';
        }
    }
    
    public function login() {
        // Nếu form đăng nhập được submit
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $username = isset($_POST['username']) ? $_POST['username'] : "";
            $password = isset($_POST['password']) ? $_POST['password'] : "";
            
            $errors = [];
            
            // Validate dữ liệu
            if(empty($username)) {
                $errors[] = "Tên đăng nhập không được để trống.";
            }
            
            if(empty($password)) {
                $errors[] = "Mật khẩu không được để trống.";
            }
            
            // Nếu không có lỗi, tiến hành đăng nhập
            if(empty($errors)) {
                $this->userModel->username = $username;
                
                // Kiểm tra xem username có tồn tại không
                if($this->userModel->usernameExists()) {
                    // Xác thực mật khẩu
                    if(password_verify($password, $this->userModel->password)) {
                        // Đăng nhập thành công, lưu thông tin vào session
                        session_start();
                        $_SESSION['user_id'] = $this->userModel->id;
                        $_SESSION['username'] = $this->userModel->username;
                        
                        // Chuyển hướng đến trang chủ
                        header("Location: index.php?action=home");
                        exit();
                    } else {
                        $errors[] = "Sai tên đăng nhập hoặc mật khẩu.";
                    }
                } else {
                    $errors[] = "Sai tên đăng nhập hoặc mật khẩu.";
                }
            }
            
            // Hiển thị lại form đăng nhập với thông báo lỗi
            include __DIR__ . '/../views/login.php';
        } else {
            // Hiển thị form đăng nhập
            include __DIR__ . '/../views/login.php';
        }
    }
    
    public function logout() {
        session_start();
        
        // Xóa tất cả các session
        $_SESSION = array();
        
        // Xóa cookie session
        if(ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Hủy session
        session_destroy();
        
        // Chuyển hướng đến trang đăng nhập
        header("Location: index.php?action=login");
        exit();
    }
}
?> 