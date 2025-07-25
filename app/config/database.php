<?php
class Database {
    private $host = "localhost";
    private $port = "5432"; // Cổng mặc định của PostgreSQL
    private $db_name = "gheday"; // tên CSDL 
    private $username = "postgres";     // tài khoản PostgreSQL
    private $password = "1234";  // mật khẩu 
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name}",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Kết nối PostgreSQL thành công!";
        } catch (PDOException $e) {
            echo "Kết nối thất bại: " . $e->getMessage();
            exit();
        }

        return $this->conn;
    }
}
?>
