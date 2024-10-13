<?php
require_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

$message = ''; // Khởi tạo biến thông báo

// Kiểm tra xem có dữ liệu gửi lên từ form không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_POST['user_id'];

    // Thực hiện truy vấn để thêm bài viết vào cơ sở dữ liệu
    $stmt = $db->prepare("INSERT INTO posts (user_id, title, content) VALUES (:user_id, :title, :content)");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);

    if ($stmt->execute()) {
        $message = 'Thêm bài viết thành công';
        header("refresh:1; url=/app/views/posts/index.php");
        exit();
    } else {
        $message = 'Có lỗi xảy ra. Vui lòng thử lại.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Bài Viết</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/app/views/index.php">My Story Corner</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/app/views/index.php">Trang Chủ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/app/views/posts/create.php">Tạo Bài Viết</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container mt-4">
    <h1>Tạo Bài Viết Mới</h1>
    
    <!-- Hiển thị thông báo nếu có -->
    <?php if ($message): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <div class="form-group">
            <label for="title">Tiêu đề</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="content">Nội dung</label>
            <textarea class="form-control" id="content" name="content" required></textarea>
        </div>
        <input type="hidden" name="user_id" value="1">
        <button type="submit" class="btn btn-primary">Tạo Bài Viết</button>
        <a href="/app/views/posts/index.php" class="btn btn-secondary ml-2">Trở Lại</a>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
