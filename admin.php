<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include necessary files
require_once 'app/init.php';

// Get action from URL
$action = $_GET['action'] ?? 'login';

// Route to appropriate controller method
switch ($action) {
    case 'login':
        $adminController = new AdminController();
        $adminController->login();
        break;
        
    case 'dashboard':
        $adminController = new AdminController();
        $adminController->dashboard();
        break;
        
    case 'logout':
        $adminController = new AdminController();
        $adminController->logout();
        break;
        
    case 'customers':
        $adminController = new AdminController();
        $adminController->customers();
        break;
        
    case 'customer_detail':
        $customer_id = $_GET['id'] ?? 0;
        $adminController = new AdminController();
        $adminController->customerDetail($customer_id);
        break;
        
    case 'delete_customer':
        $adminController = new AdminController();
        $adminController->deleteCustomer();
        break;
        
    case 'boats':
        $adminController = new AdminController();
        $adminController->boats();
        break;
        
    case 'trips':
        $adminController = new AdminController();
        $adminController->trips();
        break;
        
    case 'bookings':
        $adminController = new AdminController();
        $adminController->bookings();
        break;
        
    case 'invoices':
        $adminController = new AdminController();
        $adminController->invoices();
        break;
        
    case 'reports':
        $adminController = new AdminController();
        $adminController->reports();
        break;
        
    case 'settings':
        $adminController = new AdminController();
        $adminController->settings();
        break;
        
    default:
        // Redirect to login if action not found
        header("Location: admin.php?action=login");
        exit();
}
?> 