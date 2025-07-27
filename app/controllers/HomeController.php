<?php
require_once __DIR__ . '/../core/Controller.php';

class HomeController extends Controller {
    public function index() {
        // Redirect to customer home
        header("Location: index.php?controller=customer&action=home");
        exit();
    }
}
?>

