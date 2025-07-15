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

    public function create() {
        $query = "INSERT INTO {$this->table_name}
                 (username, password, fullname, address, phone)
                 VALUES (:username, :password, :fullname, :address, :phone)";

        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->fullname = htmlspecialchars(strip_tags($this->fullname));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->phone = htmlspecialchars(strip_tags($this->phone));

        // Mã hóa mật khẩu
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);

        // Gán giá trị vào câu lệnh
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $password_hash);
        $stmt->bindParam(":fullname", $this->fullname);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":phone", $this->phone);

        return $stmt->execute();
    }

    public function usernameExists() {
        $query = "SELECT id, username, password FROM {$this->table_name}
                  WHERE username = :username LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $this->username);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->id = $row['id'];
            $this->username = $row['username'];
            $this->password = $row['password'];
            return true;
        }

        return false;
    }
}
?>
