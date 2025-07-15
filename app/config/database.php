<?php
class Database {
    private $host = "localhost";
    private $db_name = "ct467_project";
    private $username = "root";
    private $password = "161163Nhon@";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Kết nối thất bại: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
