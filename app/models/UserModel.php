<?php
require_once __DIR__ . '/../config/database.php';

class UserModel {
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $password;
    public $fullname;
    public $email;
    public $address;
    public $phone;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Tạo tài khoản mới
    public function create() {
        try {
            $query = "INSERT INTO {$this->table_name} 
                      (username, password, fullname, email, address, phone) 
                      VALUES (:username, :password, :fullname, :email, :address, :phone)";
            
            $stmt = $this->conn->prepare($query);
    
            // Làm sạch dữ liệu
            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->password = htmlspecialchars(strip_tags($this->password));
            $this->fullname = htmlspecialchars(strip_tags($this->fullname));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->address = htmlspecialchars(strip_tags($this->address));
            $this->phone = htmlspecialchars(strip_tags($this->phone));
    
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
    
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":password", $password_hash);
            $stmt->bindParam(":fullname", $this->fullname);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":address", $this->address);
            $stmt->bindParam(":phone", $this->phone);
    
            if ($stmt->execute()) {
                $this->id = $this->conn->lastInsertId(); // Gán id nếu tạo thành công
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Đăng ký lỗi: " . $e->getMessage());
            return false;
        }
    }
    
    // Kiểm tra username đã tồn tại chưa
    public function usernameExists() {
        $query = "SELECT id FROM {$this->table_name} WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $this->username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    // Kiểm tra email đã tồn tại chưa
    public function emailExists() {
        $query = "SELECT id FROM {$this->table_name} WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    // Kiểm tra số điện thoại đã tồn tại chưa
    public function phoneExists() {
        $query = "SELECT id FROM {$this->table_name} WHERE phone = :phone LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    // Lấy thông tin người dùng theo username
    public function getByUsername($username) {
        $query = "SELECT * FROM {$this->table_name} WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } 

    // Lấy thông tin người dùng theo id
    public function getById($id) {
        $query = "SELECT * FROM {$this->table_name} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Kiểm tra xem username có phải là admin không
    public function isAdmin($username) {
        // Kiểm tra trong bảng users với role admin hoặc super_admin
        $query = "SELECT * FROM {$this->table_name} 
                  WHERE username = :username 
                  AND role IN ('admin', 'super_admin') 
                  AND status = 'active' 
                  LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            // Debug: Ghi log kết quả
            error_log("isAdmin check for '$username': FOUND in users table with role: " . $result['role']);
            error_log("Admin data: " . print_r($result, true));
            return $result;
        }
        
        // Debug: Ghi log kết quả
        error_log("isAdmin check for '$username': NOT FOUND or not admin");
        return false;
    }

    // Kiểm tra role của user
    public function getUserRole($username) {
        $query = "SELECT role FROM {$this->table_name} WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['role'] : null;
    }

    // Kiểm tra xem user có quyền admin không
    public function hasAdminRole($username) {
        $role = $this->getUserRole($username);
        return in_array($role, ['admin', 'super_admin']);
    }

    // Cập nhật thông tin profile
    public function updateProfile() {
        try {
            $query = "UPDATE {$this->table_name} 
                      SET fullname = :fullname, email = :email, address = :address, phone = :phone 
                      WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
    
            // Làm sạch dữ liệu
            $this->fullname = htmlspecialchars(strip_tags($this->fullname));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->address = htmlspecialchars(strip_tags($this->address));
            $this->phone = htmlspecialchars(strip_tags($this->phone));
    
            $stmt->bindParam(":fullname", $this->fullname);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":address", $this->address);
            $stmt->bindParam(":phone", $this->phone);
            $stmt->bindParam(":id", $this->id);
    
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Cập nhật profile lỗi: " . $e->getMessage());
            return false;
        }
    }

    // Cập nhật mật khẩu
    public function updatePassword() {
        try {
            $query = "UPDATE {$this->table_name} SET password = :password WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
    
            // Hash mật khẩu mới
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
    
            $stmt->bindParam(":password", $password_hash);
            $stmt->bindParam(":id", $this->id);
    
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Cập nhật mật khẩu lỗi: " . $e->getMessage());
            return false;
        }
    }
    
    // Xác thực người dùng (bằng username hoặc phone)
    public function authenticate($login_input, $password_input) {
        $query = "SELECT * FROM {$this->table_name} 
                  WHERE username = :input OR phone = :input LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":input", $login_input);
        $stmt->execute();

        if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($password_input, $user['password'])) {
                // Gán dữ liệu vào đối tượng
                $this->id = $user['id'];
                $this->username = $user['username'];
                $this->fullname = $user['fullname'];
                $this->email = $user['email'];
                $this->address = $user['address'];
                $this->phone = $user['phone'];
                return true;
            }
        }

        return false;
    }

    // Lấy tất cả users
    public function getAll($limit = null, $offset = null) {
        try {
            $query = "SELECT * FROM {$this->table_name} ORDER BY created_at DESC";
            
            if ($limit) {
                $query .= " LIMIT :limit";
                if ($offset) {
                    $query .= " OFFSET :offset";
                }
            }
            
            $stmt = $this->conn->prepare($query);
            
            if ($limit) {
                $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
                if ($offset) {
                    $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
                }
            }
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all users error: " . $e->getMessage());
            return [];
        }
    }

    // Đếm tổng số users
    public function countAll() {
        try {
            $query = "SELECT COUNT(*) as total FROM {$this->table_name}";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            error_log("Count users error: " . $e->getMessage());
            return 0;
        }
    }

    // Đếm users mới hôm nay
    public function countNewToday() {
        try {
            $query = "SELECT COUNT(*) as total FROM {$this->table_name} WHERE DATE(created_at) = CURDATE()";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            error_log("Count new users today error: " . $e->getMessage());
            return 0;
        }
    }

    // Xóa user
    public function delete($id) {
        try {
            $query = "DELETE FROM {$this->table_name} WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Delete user error: " . $e->getMessage());
            return false;
        }
    }
}
?>
