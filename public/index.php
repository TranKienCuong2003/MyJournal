<?php
// Kết nối đến cơ sở dữ liệu
try {
    $db = new PDO('mysql:host=localhost;dbname=your_db_name;charset=utf8', 'username', 'password');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Import AuthController
require_once '../controllers/AuthController.php';

// Khởi tạo AuthController
$authController = new AuthController($db);

// Routing: Xử lý yêu cầu từ người dùng
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Điều hướng dựa trên URI và phương thức HTTP
if ($requestUri === '/register') {
    if ($requestMethod === 'GET') {
        $authController->showRegister(); // Hiển thị form đăng ký
    } elseif ($requestMethod === 'POST') {
        $authController->register(); // Xử lý đăng ký
    }
} elseif ($requestUri === '/login') {
    if ($requestMethod === 'GET') {
        $authController->showLogin(); // Hiển thị form đăng nhập
    } elseif ($requestMethod === 'POST') {
        $authController->login(); // Xử lý đăng nhập
    }
} elseif ($requestUri === '/logout') {
    $authController->logout(); // Xử lý đăng xuất
} else {
    // Nếu không tìm thấy trang, có thể chuyển hướng đến trang chính hoặc hiển thị thông báo lỗi
    header("Location: /path/to/public/index.php"); // Thay đổi đường dẫn cho phù hợp
    exit();
}
