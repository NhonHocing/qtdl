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
        $errors = [];
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $fullname = $_POST['fullname'] ?? '';
            $address  = $_POST['address'] ?? '';
            $phone    = $_POST['phone'] ?? '';
    
            // Kiểm tra username hoặc phone đã tồn tại
            $this->userModel->username = $username;
            $this->userModel->phone = $phone;
    
            if ($this->userModel->usernameExists()) {
                $errors[] = 'Tên đăng nhập đã tồn tại';
            }
            if ($this->userModel->phoneExists()) {
                $errors[] = 'Số điện thoại đã tồn tại';
            }
    
            if (empty($errors)) {
                // Gán thuộc tính cho userModel
                $this->userModel->username = $username;
                $this->userModel->password = $password; // Sẽ hash trong model
                $this->userModel->fullname = $fullname;
                $this->userModel->address = $address;
                $this->userModel->phone = $phone;
    
                if ($this->userModel->create()) {
                    // Sau khi tạo tài khoản → tự động đăng nhập
                    if (session_status() === PHP_SESSION_NONE) session_start();
                    $_SESSION['user_id'] = $this->userModel->id; // đã được gán khi đăng nhập
                    $_SESSION['username'] = $this->userModel->username;
    
                    header("Location: index.php?action=home");
                    exit;
                } else {
                    $errors[] = "Đăng ký thất bại. Vui lòng thử lại.";
                }
            }
        }
    
        include(__DIR__ . '/../views/auth.php');
    }
    
    
    
    public function login() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? "";
            $password = $_POST['password'] ?? "";
            
            $errors = [];
            if(empty($username)) $errors[] = "Tên đăng nhập không được để trống.";
            if(empty($password)) $errors[] = "Mật khẩu không được để trống.";
            
            if(empty($errors)) {
                $this->userModel->username = $username;
                if($this->userModel->usernameExists()) {
                    $userData = $this->userModel->getByUsername($username);
                    if ($userData && password_verify($password, $userData['password'])) {
                        if (session_status() === PHP_SESSION_NONE) {
                            session_start();
                        }
                        $_SESSION['user_id'] = $userData['id'];
                        $_SESSION['username'] = $userData['username'];
    
                        header("Location: index.php?action=home");
                        exit();
                    } else {
                        $errors[] = "Sai tên đăng nhập hoặc mật khẩu.";
                    }
                } else {
                    $errors[] = "Sai tên đăng nhập hoặc mật khẩu.";
                }
            }
    
            include(__DIR__ . '/../views/auth.php');
    
        } else {
            include(__DIR__ . '/../views/auth.php');
        }
    }
    
    
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        if(ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        header("Location: index.php?action=login");
        exit();
    }
    
}
?> 