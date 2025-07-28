<?php
require_once __DIR__ . '/../models/UserModel.php';

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
            $confirm_password = $_POST['confirm_password'] ?? '';
            $fullname = $_POST['fullname'] ?? '';
            $email = $_POST['email'] ?? '';
            $address = $_POST['address'] ?? '';
            $phone = $_POST['phone'] ?? '';
    
            // Ghi log đăng ký
            error_log("Đăng ký: $username - $fullname - $email - $phone");
    
            // Validation
            if (empty($username)) $errors[] = 'Tên đăng nhập không được để trống';
            if (empty($password)) $errors[] = 'Mật khẩu không được để trống';
            if (empty($confirm_password)) $errors[] = 'Xác nhận mật khẩu không được để trống';
            if (empty($fullname)) $errors[] = 'Họ tên không được để trống';
            if (empty($email)) $errors[] = 'Email không được để trống';
            if (empty($phone)) $errors[] = 'Số điện thoại không được để trống';
            
            // Password confirmation check
            if ($password !== $confirm_password) {
                $errors[] = 'Mật khẩu xác nhận không khớp';
            }
            
            // Email validation
            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email không hợp lệ';
            }
            
            // Password strength validation
            if (!empty($password) && strlen($password) < 6) {
                $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự';
            }
    
            if (empty($errors)) {
                // Kiểm tra username, email hoặc phone đã tồn tại
                $this->userModel->username = $username;
                $this->userModel->email = $email;
                $this->userModel->phone = $phone;
    
                if ($this->userModel->usernameExists()) {
                    $errors[] = 'Tên đăng nhập đã tồn tại';
                }
                if ($this->userModel->emailExists()) {
                    $errors[] = 'Email đã tồn tại';
                }
                if ($this->userModel->phoneExists()) {
                    $errors[] = 'Số điện thoại đã tồn tại';
                }
    
                if (empty($errors)) {
                    // Gán thuộc tính cho userModel
                    $this->userModel->username = $username;
                    $this->userModel->password = $password; // Sẽ hash trong model
                    $this->userModel->fullname = $fullname;
                    $this->userModel->email = $email;
                    $this->userModel->address = $address;
                    $this->userModel->phone = $phone;
    
                    if ($this->userModel->create()) {
                        // Sau khi tạo tài khoản → tự động đăng nhập
                        if (session_status() === PHP_SESSION_NONE) session_start();
                        $_SESSION['user_id'] = $this->userModel->id;
                        $_SESSION['username'] = $this->userModel->username;
                        $_SESSION['fullname'] = $this->userModel->fullname;
                        $_SESSION['email'] = $this->userModel->email;
                        $_SESSION['phone'] = $this->userModel->phone;
                        $_SESSION['address'] = $this->userModel->address;
    
                        header("Location: index.php?controller=customer&action=home");
                        exit;
                    } else {
                        $errors[] = "Đăng ký thất bại. Vui lòng thử lại.";
                        error_log("User creation failed for username: $username");
                    }
                }
            }
        }
    
        include(__DIR__ . '/../views/auth/register.php');
    }
    
    public function login() {
        $errors = [];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? "";
            $password = $_POST['password'] ?? "";
            
            if(empty($username)) $errors[] = "Tên đăng nhập không được để trống.";
            if(empty($password)) $errors[] = "Mật khẩu không được để trống.";
            
            if(empty($errors)) {
                // Khởi tạo session nếu chưa có
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                
                // Kiểm tra user trong bảng users
                $userData = $this->userModel->getByUsername($username);
                
                if ($userData && password_verify($password, $userData['password'])) {
                    // Kiểm tra role để quyết định chuyển hướng
                    $role = $userData['role'] ?? 'customer';
                    
                    if (in_array($role, ['admin', 'super_admin'])) {
                        // Đăng nhập admin thành công
                        $_SESSION['admin_id'] = $userData['id'];
                        $_SESSION['admin_username'] = $userData['username'];
                        $_SESSION['admin_fullname'] = $userData['fullname'];
                        $_SESSION['admin_email'] = $userData['email'];
                        $_SESSION['admin_role'] = $role;
                        
                        // Xóa session customer nếu có
                        unset($_SESSION['user_id']);
                        unset($_SESSION['username']);
                        unset($_SESSION['fullname']);
                        unset($_SESSION['email']);
                        unset($_SESSION['phone']);
                        unset($_SESSION['address']);
        
                        // Chuyển hướng đến trang admin dashboard
                        header("Location: index.php?controller=admin&action=dashboard");
                        exit();
                    } else {
                        // Đăng nhập customer thành công
                        $_SESSION['user_id'] = $userData['id'];
                        $_SESSION['username'] = $userData['username'];
                        $_SESSION['fullname'] = $userData['fullname'];
                        $_SESSION['email'] = $userData['email'];
                        $_SESSION['phone'] = $userData['phone'];
                        $_SESSION['address'] = $userData['address'];
                        $_SESSION['user_role'] = $role;
                        
                        // Xóa session admin nếu có
                        unset($_SESSION['admin_id']);
                        unset($_SESSION['admin_username']);
                        unset($_SESSION['admin_fullname']);
                        unset($_SESSION['admin_email']);
                        unset($_SESSION['admin_role']);
        
                        // Chuyển hướng đến trang customer home
                        header("Location: index.php?controller=customer&action=home");
                        exit();
                    }
                } else {
                    $errors[] = "Sai tên đăng nhập hoặc mật khẩu.";
                }
            }
        }
    
        include(__DIR__ . '/../views/auth/login.php');
    }
    
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Clear all session variables
        $_SESSION = [];
        
        // Destroy the session cookie
        if(ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Destroy the session
        session_destroy();
        
        // Redirect to home page
        header("Location: index.php?controller=customer&action=home");
        exit();
    }
    
    public function updateProfile() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
        
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = $_POST['fullname'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            
            // Validation
            if (empty($fullname)) $errors[] = 'Họ tên không được để trống';
            if (empty($email)) $errors[] = 'Email không được để trống';
            if (empty($phone)) $errors[] = 'Số điện thoại không được để trống';
            
            // Email validation
            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email không hợp lệ';
            }
            
            if (empty($errors)) {
                // Check if email or phone already exists for other users
                $this->userModel->email = $email;
                $this->userModel->phone = $phone;
                
                // Get current user data to compare
                $currentUser = $this->userModel->getById($_SESSION['user_id']);
                
                if ($currentUser['email'] !== $email && $this->userModel->emailExists()) {
                    header("Location: index.php?controller=customer&action=profile&error=email_exists");
                    exit();
                }
                
                if ($currentUser['phone'] !== $phone && $this->userModel->phoneExists()) {
                    header("Location: index.php?controller=customer&action=profile&error=phone_exists");
                    exit();
                }
                
                // Update user profile
                $this->userModel->id = $_SESSION['user_id'];
                $this->userModel->fullname = $fullname;
                $this->userModel->email = $email;
                $this->userModel->phone = $phone;
                $this->userModel->address = $address;
                
                if ($this->userModel->updateProfile()) {
                    // Update session data
                    $_SESSION['fullname'] = $fullname;
                    $_SESSION['email'] = $email;
                    $_SESSION['phone'] = $phone;
                    $_SESSION['address'] = $address;
                    
                    header("Location: index.php?controller=customer&action=profile&success=profile");
                    exit();
                } else {
                    $errors[] = "Cập nhật thông tin thất bại. Vui lòng thử lại.";
                }
            }
        }
        
        include(__DIR__ . '/../views/profile.php');
    }
    
    public function changePassword() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
        
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            
            // Validation
            if (empty($current_password)) $errors[] = 'Mật khẩu hiện tại không được để trống';
            if (empty($new_password)) $errors[] = 'Mật khẩu mới không được để trống';
            if (empty($confirm_password)) $errors[] = 'Xác nhận mật khẩu không được để trống';
            
            if ($new_password !== $confirm_password) {
                $errors[] = 'Mật khẩu xác nhận không khớp';
            }
            
            if (!empty($new_password) && strlen($new_password) < 6) {
                $errors[] = 'Mật khẩu mới phải có ít nhất 6 ký tự';
            }
            
            if (empty($errors)) {
                // Verify current password
                $userData = $this->userModel->getById($_SESSION['user_id']);
                if ($userData && password_verify($current_password, $userData['password'])) {
                    // Update password
                    $this->userModel->id = $_SESSION['user_id'];
                    $this->userModel->password = $new_password;
                    
                    if ($this->userModel->updatePassword()) {
                        header("Location: index.php?controller=customer&action=profile&success=password");
                        exit();
                    } else {
                        $errors[] = "Thay đổi mật khẩu thất bại. Vui lòng thử lại.";
                    }
                } else {
                                            header("Location: index.php?controller=customer&action=profile&error=current_password");
                    exit();
                }
            }
        }
        
        include(__DIR__ . '/../views/profile.php');
    }
}
?> 