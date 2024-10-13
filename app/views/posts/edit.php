<?php
require_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

$message = '';

// Kiểm tra xem có ID bài viết nào được truyền vào không
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    // Lấy thông tin bài viết từ cơ sở dữ liệu
    $stmt = $db->prepare("SELECT * FROM posts WHERE id = :id");
    $stmt->bindParam(':id', $post_id);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    // Kiểm tra nếu bài viết tồn tại
    if (!$post) {
        die('Bài viết không tồn tại.');
    }

    // Kiểm tra xem có dữ liệu gửi lên từ form không
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $user_id = $_POST['user_id'];

        // Cập nhật bài viết trong cơ sở dữ liệu
        $update_stmt = $db->prepare("UPDATE posts SET title = :title, content = :content WHERE id = :id");
        $update_stmt->bindParam(':id', $post_id);
        $update_stmt->bindParam(':title', $title);
        $update_stmt->bindParam(':content', $content);

        if ($update_stmt->execute()) {
            $message = 'Cập nhật bài viết thành công.';
            header("refresh:1; url=/app/views/posts/index.php");
            exit();
        } else {
            $message = 'Có lỗi xảy ra. Vui lòng thử lại.';
        }
    }
} else {
    die('ID bài viết không được cung cấp.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh Sửa Bài Viết</title>
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
    <h1>Chỉnh Sửa Bài Viết</h1>

    <?php if ($message): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="title">Tiêu đề</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
        </div>
        <div class="form-group">
            <label for="content">Nội dung</label>
            <textarea class="form-control" id="content" name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea>
        </div>
        <input type="hidden" name="user_id" value="1">
        <button type="submit" class="btn btn-primary">Cập Nhật Bài Viết</button>
        <a href="/app/views/posts/index.php" class="btn btn-secondary ml-2">Trở Lại</a>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
