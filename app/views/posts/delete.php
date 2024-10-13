<?php
require_once '../../config/database.php';

// Tạo đối tượng Database và lấy kết nối
$database = new Database();
$db = $database->getConnection();

// Kiểm tra xem có ID bài viết được truyền vào không
if (isset($_GET['id'])) {
    $postId = $_GET['id'];

    // Chuẩn bị câu lệnh xóa
    $stmt = $db->prepare("DELETE FROM posts WHERE id = :id");
    $stmt->bindParam(':id', $postId);

    // Thực thi câu lệnh xóa
    if ($stmt->execute()) {
        // Nếu xóa thành công, chuyển hướng về trang danh sách bài viết
        header("Location: /app/views/posts/index.php?message=Xóa bài viết thành công.");
        exit;
    } else {
        echo "Có lỗi xảy ra khi xóa bài viết.";
    }
} else {
    echo "ID bài viết không được cung cấp.";
}
?>
