<?php
require_once __DIR__ . '/../config/database.php';

class AdminModel {
    private $conn;
    private $table_name = "admin_users";

    public $id;
    public $username;
    public $password;
    public $fullname;
    public $email;
    public $role;
    public $status;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Xác thực admin
    public function authenticate($username, $password) {
        try {
            $query = "SELECT * FROM {$this->table_name} WHERE username = :username AND status = 'active' LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":username", $username);
            $stmt->execute();

            if ($admin = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (password_verify($password, $admin['password'])) {
                    // Cập nhật last_login
                    $this->updateLastLogin($admin['id']);
                    
                    // Gán dữ liệu vào đối tượng
                    $this->id = $admin['id'];
                    $this->username = $admin['username'];
                    $this->fullname = $admin['fullname'];
                    $this->email = $admin['email'];
                    $this->role = $admin['role'];
                    $this->status = $admin['status'];
                    
                    return true;
                }
            }
            return false;
        } catch (PDOException $e) {
            error_log("Admin authentication error: " . $e->getMessage());
            return false;
        }
    }

    // Cập nhật thời gian đăng nhập cuối
    private function updateLastLogin($admin_id) {
        try {
            $query = "UPDATE {$this->table_name} SET last_login = NOW() WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $admin_id);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update last login error: " . $e->getMessage());
        }
    }

    // Lấy thông tin admin theo ID
    public function getById($id) {
        try {
            $query = "SELECT * FROM {$this->table_name} WHERE id = :id LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get admin by ID error: " . $e->getMessage());
            return false;
        }
    }

    // Lấy thông tin admin theo username
    public function getByUsername($username) {
        try {
            $query = "SELECT * FROM {$this->table_name} WHERE username = :username LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":username", $username);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get admin by username error: " . $e->getMessage());
            return false;
        }
    }

    // Lấy tất cả admin
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
            error_log("Get all admins error: " . $e->getMessage());
            return [];
        }
    }

    // Tạo admin mới
    public function create($data) {
        try {
            $query = "INSERT INTO {$this->table_name} 
                      (username, password, fullname, email, role, status) 
                      VALUES (:username, :password, :fullname, :email, :role, :status)";
            
            $stmt = $this->conn->prepare($query);
    
            // Làm sạch dữ liệu
            $this->username = htmlspecialchars(strip_tags($data['username']));
            $this->fullname = htmlspecialchars(strip_tags($data['fullname']));
            $this->email = htmlspecialchars(strip_tags($data['email']));
            $this->role = htmlspecialchars(strip_tags($data['role']));
            $this->status = htmlspecialchars(strip_tags($data['status']));
    
            // Hash password
            $password_hash = password_hash($data['password'], PASSWORD_BCRYPT);
    
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":password", $password_hash);
            $stmt->bindParam(":fullname", $this->fullname);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":role", $this->role);
            $stmt->bindParam(":status", $this->status);
    
            if ($stmt->execute()) {
                $this->id = $this->conn->lastInsertId();
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Create admin error: " . $e->getMessage());
            return false;
        }
    }

    // Cập nhật thông tin admin
    public function update($id, $data) {
        try {
            $query = "UPDATE {$this->table_name} 
                      SET fullname = :fullname, email = :email, role = :role, status = :status 
                      WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
    
            // Làm sạch dữ liệu
            $fullname = htmlspecialchars(strip_tags($data['fullname']));
            $email = htmlspecialchars(strip_tags($data['email']));
            $role = htmlspecialchars(strip_tags($data['role']));
            $status = htmlspecialchars(strip_tags($data['status']));
    
            $stmt->bindParam(":fullname", $fullname);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":role", $role);
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":id", $id);
    
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update admin error: " . $e->getMessage());
            return false;
        }
    }

    // Thay đổi mật khẩu admin
    public function changePassword($id, $new_password) {
        try {
            $query = "UPDATE {$this->table_name} SET password = :password WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
    
            // Hash mật khẩu mới
            $password_hash = password_hash($new_password, PASSWORD_BCRYPT);
    
            $stmt->bindParam(":password", $password_hash);
            $stmt->bindParam(":id", $id);
    
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Change admin password error: " . $e->getMessage());
            return false;
        }
    }

    // Xóa admin
    public function delete($id) {
        try {
            $query = "DELETE FROM {$this->table_name} WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Delete admin error: " . $e->getMessage());
            return false;
        }
    }

    // Kiểm tra username đã tồn tại
    public function usernameExists($username, $exclude_id = null) {
        try {
            $query = "SELECT id FROM {$this->table_name} WHERE username = :username";
            if ($exclude_id) {
                $query .= " AND id != :exclude_id";
            }
            $query .= " LIMIT 1";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":username", $username);
            if ($exclude_id) {
                $stmt->bindParam(":exclude_id", $exclude_id);
            }
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
        } catch (PDOException $e) {
            error_log("Check username exists error: " . $e->getMessage());
            return false;
        }
    }

    // Kiểm tra email đã tồn tại
    public function emailExists($email, $exclude_id = null) {
        try {
            $query = "SELECT id FROM {$this->table_name} WHERE email = :email";
            if ($exclude_id) {
                $query .= " AND id != :exclude_id";
            }
            $query .= " LIMIT 1";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $email);
            if ($exclude_id) {
                $stmt->bindParam(":exclude_id", $exclude_id);
            }
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
        } catch (PDOException $e) {
            error_log("Check email exists error: " . $e->getMessage());
            return false;
        }
    }

    // Đếm tổng số admin
    public function countAll() {
        try {
            $query = "SELECT COUNT(*) as total FROM {$this->table_name}";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            error_log("Count admins error: " . $e->getMessage());
            return 0;
        }
    }

    // Lấy thống kê admin
    public function getStats() {
        try {
            $query = "SELECT 
                        COUNT(*) as total_admins,
                        COUNT(CASE WHEN status = 'active' THEN 1 END) as active_admins,
                        COUNT(CASE WHEN status = 'inactive' THEN 1 END) as inactive_admins,
                        COUNT(CASE WHEN role = 'super_admin' THEN 1 END) as super_admins,
                        COUNT(CASE WHEN role = 'admin' THEN 1 END) as regular_admins
                      FROM {$this->table_name}";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get admin stats error: " . $e->getMessage());
            return [];
        }
    }
}
?> 