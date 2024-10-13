<?php
require_once '../models/User.php';

class AuthController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Hiển thị trang đăng ký
    public function showRegister() {
        include '../views/auth/register.php';
    }

    // Xử lý đăng ký
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = new User($this->db);
            if ($user->register($username, $password)) {
                header("Location: /path/to/public/index.php/login");
            } else {
                // Thông báo lỗi
                echo "Đăng ký thất bại.";
            }
        }
    }

    // Hiển thị trang đăng nhập
    public function showLogin() {
        include '../views/auth/login.php';
    }

    // Xử lý đăng nhập
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = new User($this->db);
            $loggedInUser = $user->login($username, $password);

            if ($loggedInUser) {
                session_start();
                $_SESSION['user_id'] = $loggedInUser['id'];
                header("Location: /path/to/public/index.php/posts");
            } else {
                // Thông báo lỗi
                echo "Đăng nhập thất bại.";
            }
        }
    }

    // Đăng xuất
    public function logout() {
        session_start();
        session_destroy();
        header("Location: /path/to/public/index.php/login");
    }
}
