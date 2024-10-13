<?php
require_once '../../config/database.php';

// Tạo đối tượng Database và lấy kết nối
$database = new Database();
$db = $database->getConnection();

// Kiểm tra xem có ID bài viết được truyền vào không
if (isset($_POST['id'])) {
    $postId = $_POST['id'];

    // Lấy bài viết từ cơ sở dữ liệu
    $stmt = $db->prepare("SELECT * FROM posts WHERE id = :id");
    $stmt->bindParam(':id', $postId);
    $stmt->execute();

    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    // Kiểm tra xem bài viết có tồn tại không
    if ($post) {
        // Tạo biến tạm thời để lưu giá trị
        $userId = $post['user_id'];
        $title = $post['title'] . ' - Copy'; // Thêm đuôi - Copy vào tiêu đề
        $content = $post['content'];

        // Chuẩn bị truy vấn để sao chép bài viết
        $copyStmt = $db->prepare("INSERT INTO posts (user_id, title, content, created_at, updated_at) VALUES (:user_id, :title, :content, NOW(), NOW())");
        
        // Ràng buộc các tham số
        $copyStmt->bindParam(':user_id', $userId);
        $copyStmt->bindParam(':title', $title);
        $copyStmt->bindParam(':content', $content);

        // Thực hiện sao chép bài viết
        if ($copyStmt->execute()) {
            // Chuyển hướng về trang bài viết với thông báo thành công
            header("Location: /app/views/posts/index.php?message=Thêm bài viết thành công");
            exit();
        } else {
            echo "Có lỗi xảy ra khi sao chép bài viết.";
        }
    } else {
        echo "Bài viết không tồn tại.";
    }
} else {
    echo "ID bài viết không được cung cấp.";
}
?>
