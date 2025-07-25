<?php
require_once __DIR__ . '/../config/database.php';

class UserModel {
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $password;
    public $fullname;
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
                      (username, password, fullname, address, phone) 
                      VALUES (:username, :password, :fullname, :address, :phone)";
            
            $stmt = $this->conn->prepare($query);
    
            // Làm sạch dữ liệu
            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->password = htmlspecialchars(strip_tags($this->password));
            $this->fullname = htmlspecialchars(strip_tags($this->fullname));
            $this->address  = htmlspecialchars(strip_tags($this->address));
            $this->phone    = htmlspecialchars(strip_tags($this->phone));
    
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
    
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":password", $password_hash);
            $stmt->bindParam(":fullname", $this->fullname);
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
                $this->id       = $user['id'];
                $this->username = $user['username'];
                $this->fullname = $user['fullname'];
                $this->address  = $user['address'];
                $this->phone    = $user['phone'];
                return true;
            }
        }

        return false;
    }
}
?>
