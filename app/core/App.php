<?php
class App {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseURL();

        // Handle action-based routing (index.php?action=login)
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            
            // Map actions to controllers
            switch ($action) {
                case 'login':
                case 'register':
                case 'logout':
                case 'update_profile':
                case 'change_password':
                    $this->controller = 'AuthController';
                    $this->method = $action;
                    break;
                case 'book_ticket':
                    $this->controller = 'BookingController';
                    $this->method = 'bookTicket';
                    break;
                case 'cancel_booking':
                    $this->controller = 'BookingController';
                    $this->method = 'cancelBooking';
                    break;
                default:
                    $this->controller = 'HomeController';
                    $this->method = 'index';
            }
        }
        // Handle view-based routing (index.php?view=booking)
        elseif (isset($_GET['view'])) {
            $view = $_GET['view'];
            
            switch ($view) {
                case 'booking':
                    $this->controller = 'HomeController';
                    $this->method = 'booking';
                    break;
                case 'booking_history':
                    $this->controller = 'HomeController';
                    $this->method = 'bookingHistory';
                    break;
                case 'profile':
                    $this->controller = 'HomeController';
                    $this->method = 'profile';
                    break;
                default:
                    $this->controller = 'HomeController';
                    $this->method = 'index';
            }
        }
        // Handle URL-based routing
        else {
            if (isset($url[0]) && file_exists('../app/controllers/' . ucfirst($url[0]) . 'Controller.php')) {
                $this->controller = ucfirst($url[0]) . 'Controller';
                unset($url[0]);
            }

            if (isset($url[1]) && method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseURL() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
?>

