<?php
require_once __DIR__ . '/../config/database.php';

class BookingModel {
    private $conn;
    private $table_name = "bookings";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Lấy kết nối database
    public function getConnection() {
        return $this->conn;
    }

    // Tạo booking mới
    public function create($data) {
        try {
            $query = "INSERT INTO {$this->table_name} 
                      (user_id, route, departure_date, departure_time, adult_tickets, child_tickets, 
                       adult_price, child_price, total_price, passenger_name, phone, email, 
                       special_requests, status, created_at) 
                      VALUES (:user_id, :route, :departure_date, :departure_time, :adult_tickets, :child_tickets,
                              :adult_price, :child_price, :total_price, :passenger_name, :phone, :email,
                              :special_requests, :status, NOW())";
            
            $stmt = $this->conn->prepare($query);
    
            // Bind parameters
            $stmt->bindParam(":user_id", $data['user_id']);
            $stmt->bindParam(":route", $data['route']);
            $stmt->bindParam(":departure_date", $data['departure_date']);
            $stmt->bindParam(":departure_time", $data['departure_time']);
            $stmt->bindParam(":adult_tickets", $data['adult_tickets']);
            $stmt->bindParam(":child_tickets", $data['child_tickets']);
            $stmt->bindParam(":adult_price", $data['adult_price']);
            $stmt->bindParam(":child_price", $data['child_price']);
            $stmt->bindParam(":total_price", $data['total_price']);
            $stmt->bindParam(":passenger_name", $data['passenger_name']);
            $stmt->bindParam(":phone", $data['phone']);
            $stmt->bindParam(":email", $data['email']);
            $stmt->bindParam(":special_requests", $data['special_requests']);
            $stmt->bindParam(":status", $data['status']);
    
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Booking creation error: " . $e->getMessage());
            return false;
        }
    }

    // Lấy booking theo ID
    public function getById($id) {
        try {
            $query = "SELECT * FROM {$this->table_name} WHERE id = :id LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get booking by ID error: " . $e->getMessage());
            return false;
        }
    }

    // Lấy tất cả booking của user
    public function getByUserId($user_id) {
        try {
            $query = "SELECT * FROM {$this->table_name} WHERE user_id = :user_id ORDER BY created_at DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get bookings by user ID error: " . $e->getMessage());
            return [];
        }
    }

    // Cập nhật trạng thái booking
    public function updateStatus($id, $status) {
        try {
            $query = "UPDATE {$this->table_name} SET status = :status, updated_at = NOW() WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":id", $id);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update booking status error: " . $e->getMessage());
            return false;
        }
    }

    // Lấy booking theo trạng thái
    public function getByStatus($status) {
        try {
            $query = "SELECT * FROM {$this->table_name} WHERE status = :status ORDER BY created_at DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":status", $status);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get bookings by status error: " . $e->getMessage());
            return [];
        }
    }

    // Lấy booking theo khoảng thời gian
    public function getByDateRange($start_date, $end_date, $user_id = null) {
        try {
            $query = "SELECT * FROM {$this->table_name} WHERE departure_date BETWEEN :start_date AND :end_date";
            if ($user_id) {
                $query .= " AND user_id = :user_id";
            }
            $query .= " ORDER BY departure_date ASC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":start_date", $start_date);
            $stmt->bindParam(":end_date", $end_date);
            if ($user_id) {
                $stmt->bindParam(":user_id", $user_id);
            }
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get bookings by date range error: " . $e->getMessage());
            return [];
        }
    }

    // Đếm số booking theo trạng thái
    public function countByStatus($status, $user_id = null) {
        try {
            $query = "SELECT COUNT(*) as count FROM {$this->table_name} WHERE status = :status";
            if ($user_id) {
                $query .= " AND user_id = :user_id";
            }
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":status", $status);
            if ($user_id) {
                $stmt->bindParam(":user_id", $user_id);
            }
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] ?? 0;
        } catch (PDOException $e) {
            error_log("Count bookings by status error: " . $e->getMessage());
            return 0;
        }
    }

    // Xóa booking (soft delete)
    public function delete($id) {
        try {
            $query = "UPDATE {$this->table_name} SET status = 'deleted', updated_at = NOW() WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Delete booking error: " . $e->getMessage());
            return false;
        }
    }

    // Lấy thống kê booking
    public function getStats($user_id = null) {
        try {
            $query = "SELECT 
                        COUNT(*) as total_bookings,
                        SUM(total_price) as total_revenue,
                        COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending_count,
                        COUNT(CASE WHEN status = 'confirmed' THEN 1 END) as confirmed_count,
                        COUNT(CASE WHEN status = 'completed' THEN 1 END) as completed_count,
                        COUNT(CASE WHEN status = 'cancelled' THEN 1 END) as cancelled_count
                      FROM {$this->table_name}";
            
            if ($user_id) {
                $query .= " WHERE user_id = :user_id";
            }
            
            $stmt = $this->conn->prepare($query);
            if ($user_id) {
                $stmt->bindParam(":user_id", $user_id);
            }
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get booking stats error: " . $e->getMessage());
            return [];
        }
    }

    // Lấy tất cả bookings
    public function getAll($limit = null, $offset = null) {
        try {
            $query = "SELECT b.*, u.fullname as customer_name, u.phone as customer_phone 
                      FROM {$this->table_name} b 
                      LEFT JOIN users u ON b.user_id = u.id 
                      ORDER BY b.created_at DESC";
            
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
            error_log("Get all bookings error: " . $e->getMessage());
            return [];
        }
    }

    // Đếm tổng số bookings
    public function countAll() {
        try {
            $query = "SELECT COUNT(*) as total FROM {$this->table_name}";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            error_log("Count bookings error: " . $e->getMessage());
            return 0;
        }
    }

    // Đếm bookings hôm nay
    public function countToday() {
        try {
            $query = "SELECT COUNT(*) as total FROM {$this->table_name} WHERE DATE(created_at) = CURDATE()";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            error_log("Count bookings today error: " . $e->getMessage());
            return 0;
        }
    }

    // Lấy tổng doanh thu
    public function getTotalRevenue() {
        try {
            $query = "SELECT SUM(total_price) as total FROM {$this->table_name} WHERE status IN ('confirmed', 'completed')";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            error_log("Get total revenue error: " . $e->getMessage());
            return 0;
        }
    }

    // Lấy doanh thu hôm nay
    public function getRevenueToday() {
        try {
            $query = "SELECT SUM(total_price) as total FROM {$this->table_name} 
                      WHERE DATE(created_at) = CURDATE() AND status IN ('confirmed', 'completed')";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            error_log("Get revenue today error: " . $e->getMessage());
            return 0;
        }
    }

    // Lấy doanh thu tháng này
    public function getRevenueThisMonth() {
        try {
            $query = "SELECT COALESCE(SUM(total_price), 0) as revenue 
                      FROM {$this->table_name} 
                      WHERE status IN ('confirmed', 'completed') 
                      AND MONTH(created_at) = MONTH(CURRENT_DATE()) 
                      AND YEAR(created_at) = YEAR(CURRENT_DATE())";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result['revenue'] ?? 0;
        } catch (PDOException $e) {
            error_log("Get revenue this month error: " . $e->getMessage());
            return 0;
        }
    }

    // Lấy danh sách đặt vé gần đây
    public function getRecentBookings($limit = 5) {
        try {
            $query = "SELECT * FROM {$this->table_name} ORDER BY created_at DESC LIMIT :limit";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get recent bookings error: " . $e->getMessage());
            return [];
        }
    }
}
?> 