<?php
require_once '../../config/database.php';

// Tạo đối tượng Database và lấy kết nối
$database = new Database();
$db = $database->getConnection();

// Kiểm tra xem có ID bài viết được truyền vào không
if (isset($_GET['id'])) {
    $postId = $_GET['id'];

    // Lấy bài viết từ cơ sở dữ liệu
    $stmt = $db->prepare("SELECT * FROM posts WHERE id = :id");
    $stmt->bindParam(':id', $postId);
    $stmt->execute();

    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    // Kiểm tra xem bài viết có tồn tại không
    if ($post) {
        // Hiển thị form xác nhận
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Xác Nhận Sao Chép Bài Viết</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <link rel="stylesheet" href="/public/css/styles.css">
        </head>
        <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/app/views/index.php">My Story Corner</a>
        </nav>
        <div class="container mt-4">
            <h1>Xác Nhận Sao Chép Bài Viết</h1>
            <form method="POST" action="copy_process.php">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($post['id']); ?>">
                <div class="form-group">
                    <label>Tiêu đề</label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($post['title']); ?> - Copy</p>
                </div>
                <div class="form-group">
                    <label>Nội dung</label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($post['content']); ?></p>
                </div>
                <p>Bạn có chắc chắn muốn sao chép bài viết này?</p>
                <button type="submit" class="btn btn-primary">Xác Nhận</button>
                <a href="/app/views/posts/index.php" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </body>
        </html>
        <?php
    } else {
        echo "Bài viết không tồn tại.";
    }
} else {
    echo "ID bài viết không được cung cấp.";
}
?>
