<?php
require_once '../models/User.php';

class UserController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Hiển thị trang đăng ký
    public function showRegister() {
        include '../views/users/register.php';
    }

    // Xử lý đăng ký người dùng
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];

            $user = new User($this->db);
            if ($user->register($username, $password)) {
                // Chuyển hướng đến trang đăng nhập sau khi đăng ký thành công
                header("Location: /login");
                exit();
            } else {
                // Thông báo lỗi nếu đăng ký thất bại
                $errorMessage = "Tên người dùng đã tồn tại. Vui lòng chọn tên khác.";
                include '../views/users/register.php';
            }
        } else {
            // Chuyển hướng đến trang đăng ký nếu không phải là yêu cầu POST
            header("Location: /register");
            exit();
        }
    }

    // Hiển thị trang đăng nhập
    public function showLogin() {
        include '../views/users/login.php';
    }

    // Xử lý đăng nhập người dùng
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = new User($this->db);
            $loggedInUser = $user->login($username, $password);

            if ($loggedInUser) {
                // Đăng nhập thành công, lưu thông tin người dùng vào phiên
                session_start();
                $_SESSION['user'] = $loggedInUser;
                // Chuyển hướng đến trang chính
                header("Location: /index.php");
                exit();
            } else {
                // Thông báo lỗi nếu đăng nhập thất bại
                $errorMessage = "Tên người dùng hoặc mật khẩu không đúng.";
                include '../views/users/login.php';
            }
        } else {
            // Chuyển hướng đến trang đăng nhập nếu không phải là yêu cầu POST
            header("Location: /login");
            exit();
        }
    }

    // Đăng xuất người dùng
    public function logout() {
        session_start();
        session_destroy();
        header("Location: /login");
        exit();
    }
}
