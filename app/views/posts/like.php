<?php
require_once '../../config/database.php';

// Tạo đối tượng Database và lấy kết nối
$database = new Database();
$db = $database->getConnection();

// Kiểm tra xem ID bài viết có được gửi từ request không
if (isset($_GET['id'])) {
    $postId = $_GET['id'];

    // Cập nhật số lượt yêu thích
    $stmt = $db->prepare("UPDATE posts SET likes = likes + 1 WHERE id = :id");
    $stmt->bindParam(':id', $postId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Chuyển hướng về trang bài viết sau khi yêu thích thành công
        header("Location: /app/views/posts/view.php?id=" . $postId);
        exit();
    } else {
        echo "Đã xảy ra lỗi trong quá trình yêu thích bài viết.";
    }
} else {
    echo "ID bài viết không hợp lệ.";
}
?>
