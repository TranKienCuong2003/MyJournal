<?php
session_start(); // Bắt đầu phiên

// Kiểm tra nếu người dùng đã đăng nhập
if (isset($_SESSION['user_id'])) {
    // Xóa thông tin phiên
    unset($_SESSION['user_id']);
    // Hủy phiên
    session_destroy();

    // Chuyển hướng đến trang đăng nhập hoặc trang chủ
    header("Location: login.php"); // Thay đổi đường dẫn nếu cần
    exit();
} else {
    // Nếu không có người dùng đăng nhập, chuyển hướng đến trang đăng nhập
    header("Location: login.php"); // Thay đổi đường dẫn nếu cần
    exit();
}
?>
