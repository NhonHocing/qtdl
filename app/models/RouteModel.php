<?php
require_once __DIR__ . '/../config/database.php';

class RouteModel {
    private $conn;
    private $table_name = "routes";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Lấy tuyến đường theo ID
    public function getById($id) {
        try {
            $query = "SELECT * FROM {$this->table_name} WHERE id = :id LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get route by ID error: " . $e->getMessage());
            return false;
        }
    }

    // Lấy tất cả tuyến đường
    public function getAll() {
        try {
            $query = "SELECT * FROM {$this->table_name} ORDER BY name ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all routes error: " . $e->getMessage());
            return [];
        }
    }

    // Tạo tuyến đường mới
    public function create($data) {
        try {
            $query = "INSERT INTO {$this->table_name} 
                      (name, departure, destination, duration, adult_price, child_price, 
                       description, status, created_at) 
                      VALUES (:name, :departure, :destination, :duration, :adult_price, :child_price,
                              :description, :status, NOW())";
            
            $stmt = $this->conn->prepare($query);
    
            // Bind parameters
            $stmt->bindParam(":name", $data['name']);
            $stmt->bindParam(":departure", $data['departure']);
            $stmt->bindParam(":destination", $data['destination']);
            $stmt->bindParam(":duration", $data['duration']);
            $stmt->bindParam(":adult_price", $data['adult_price']);
            $stmt->bindParam(":child_price", $data['child_price']);
            $stmt->bindParam(":description", $data['description']);
            $stmt->bindParam(":status", $data['status']);
    
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Route creation error: " . $e->getMessage());
            return false;
        }
    }

    // Cập nhật tuyến đường
    public function update($id, $data) {
        try {
            $query = "UPDATE {$this->table_name} 
                      SET name = :name, departure = :departure, destination = :destination,
                          duration = :duration, adult_price = :adult_price, child_price = :child_price,
                          description = :description, status = :status, updated_at = NOW()
                      WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
    
            // Bind parameters
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":name", $data['name']);
            $stmt->bindParam(":departure", $data['departure']);
            $stmt->bindParam(":destination", $data['destination']);
            $stmt->bindParam(":duration", $data['duration']);
            $stmt->bindParam(":adult_price", $data['adult_price']);
            $stmt->bindParam(":child_price", $data['child_price']);
            $stmt->bindParam(":description", $data['description']);
            $stmt->bindParam(":status", $data['status']);
    
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Route update error: " . $e->getMessage());
            return false;
        }
    }

    // Xóa tuyến đường
    public function delete($id) {
        try {
            $query = "DELETE FROM {$this->table_name} WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Route deletion error: " . $e->getMessage());
            return false;
        }
    }

    // Đếm tổng số tuyến đường
    public function countAll() {
        try {
            $query = "SELECT COUNT(*) as total FROM {$this->table_name}";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            error_log("Count routes error: " . $e->getMessage());
            return 0;
        }
    }

    // Lấy tuyến đường theo trạng thái
    public function getByStatus($status) {
        try {
            $query = "SELECT * FROM {$this->table_name} WHERE status = :status ORDER BY name ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":status", $status);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get routes by status error: " . $e->getMessage());
            return [];
        }
    }
}
?> 