<?php
require_once '../../config/database.php';

// Tạo đối tượng Database và lấy kết nối
$database = new Database();
$db = $database->getConnection();

// Kiểm tra xem có ID bài viết và bình luận được truyền vào không
if (!isset($_GET['id']) || empty($_GET['id']) || !isset($_POST['comment']) || empty(trim($_POST['comment']))) {
    die('Bài viết không tồn tại hoặc bình luận không hợp lệ.');
}

// Lấy ID bài viết từ URL
$post_id = $_GET['id'];
$comment = trim($_POST['comment']);

// Chèn bình luận vào bảng comments
$stmt = $db->prepare("INSERT INTO comments (post_id, content, user_name) VALUES (:post_id, :content, :user_name)");
$stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
$stmt->bindParam(':content', $comment, PDO::PARAM_STR);
$stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);

// Bạn có thể thay đổi biến $user_name để lấy tên người dùng từ phiên làm việc hoặc form đăng nhập.
$user_name = 'Người dùng'; // Thay thế bằng tên người dùng thực tế

if ($stmt->execute()) {
    // Chuyển hướng về trang bài viết sau khi bình luận thành công
    header("Location: /app/views/posts/view.php?id=" . $post_id);
    exit();
} else {
    echo "Đã xảy ra lỗi trong quá trình thêm bình luận.";
}
?>
