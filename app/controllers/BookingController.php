<?php
require_once __DIR__ . '/../models/BookingModel.php';

class BookingController {
    private $bookingModel;

    public function __construct() {
        $this->bookingModel = new BookingModel();
    }
    
    public function bookTicket() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }
        
        $errors = [];
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $route = $_POST['route'] ?? '';
            $departure_date = $_POST['departure_date'] ?? '';
            $departure_time = $_POST['departure_time'] ?? '';
            $adult_tickets = $_POST['adult_tickets'] ?? 0;
            $child_tickets = $_POST['child_tickets'] ?? 0;
            $passenger_name = $_POST['passenger_name'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $email = $_POST['email'] ?? '';
            $special_requests = $_POST['special_requests'] ?? '';
            
            // Validation
            if (empty($route)) $errors[] = 'Vui lòng chọn tuyến tàu';
            if (empty($departure_date)) $errors[] = 'Vui lòng chọn ngày khởi hành';
            if (empty($departure_time)) $errors[] = 'Vui lòng chọn giờ khởi hành';
            if (empty($passenger_name)) $errors[] = 'Vui lòng nhập họ tên';
            if (empty($phone)) $errors[] = 'Vui lòng nhập số điện thoại';
            if (empty($email)) $errors[] = 'Vui lòng nhập email';
            
            // Check if departure date is in the future
            if (!empty($departure_date) && $departure_date < date('Y-m-d')) {
                $errors[] = 'Ngày khởi hành phải là ngày trong tương lai';
            }
            
            // Check if at least one ticket is selected
            if ($adult_tickets == 0 && $child_tickets == 0) {
                $errors[] = 'Vui lòng chọn ít nhất 1 vé';
            }
            
            // Email validation
            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email không hợp lệ';
            }
            
            if (empty($errors)) {
                // Calculate total price
                $adult_price = $adult_tickets * 150000;
                $child_price = $child_tickets * 75000;
                $total_price = $adult_price + $child_price;
                
                // Prepare booking data
                $bookingData = [
                    'user_id' => $_SESSION['user_id'],
                    'route' => $route,
                    'departure_date' => $departure_date,
                    'departure_time' => $departure_time,
                    'adult_tickets' => $adult_tickets,
                    'child_tickets' => $child_tickets,
                    'adult_price' => $adult_price,
                    'child_price' => $child_price,
                    'total_price' => $total_price,
                    'passenger_name' => $passenger_name,
                    'phone' => $phone,
                    'email' => $email,
                    'special_requests' => $special_requests,
                    'status' => 'pending' // pending, confirmed, completed, cancelled
                ];
                
                // Create booking
                if ($this->bookingModel->create($bookingData)) {
                    $success = 'Đặt vé thành công! Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.';
                    
                    // Clear form data after successful booking
                    $_POST = [];
                } else {
                    $errors[] = 'Đặt vé thất bại. Vui lòng thử lại.';
                }
            }
        }
        
        // Include the booking view with errors/success messages
        include(__DIR__ . '/../views/booking.php');
    }
    
    public function getBookingHistory() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }
        
        $bookings = $this->bookingModel->getByUserId($_SESSION['user_id']);
        include(__DIR__ . '/../views/booking_history.php');
    }
    
    public function cancelBooking() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $booking_id = $_POST['booking_id'] ?? 0;
            
            if ($booking_id > 0) {
                // Check if booking belongs to current user
                $booking = $this->bookingModel->getById($booking_id);
                
                if ($booking && $booking['user_id'] == $_SESSION['user_id']) {
                    if ($this->bookingModel->updateStatus($booking_id, 'cancelled')) {
                        header("Location: index.php?view=booking_history&success=1");
                        exit();
                    } else {
                        header("Location: index.php?view=booking_history&error=1");
                        exit();
                    }
                } else {
                    header("Location: index.php?view=booking_history&error=2");
                    exit();
                }
            }
        }
        
        header("Location: index.php?view=booking_history");
        exit();
    }
}
?> 