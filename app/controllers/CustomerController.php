<?php
require_once __DIR__ . '/../core/Controller.php';

class CustomerController extends Controller {
    public function home() {
        $this->view('customer/home', ['title' => 'Trang chủ']);
    }
    
    public function booking() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
        // Include the booking view directly since it handles its own data
        include(__DIR__ . '/../views/customer/booking.php');
    }
    
    public function bookingHistory() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
        // Include the booking history view directly since it handles its own data
        include(__DIR__ . '/../views/customer/booking_history.php');
    }
    
    public function profile() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
        // Include the profile view directly since it handles its own data
        include(__DIR__ . '/../views/customer/profile.php');
    }
}
?> 