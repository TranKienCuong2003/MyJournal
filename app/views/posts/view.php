<?php
require_once '../../config/database.php';

// Tạo đối tượng Database và lấy kết nối
$database = new Database();
$db = $database->getConnection();

// Kiểm tra xem có ID bài viết được truyền vào không
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Bài viết không tồn tại.');
}

// Lấy ID bài viết từ URL
$post_id = $_GET['id'];

// Lấy dữ liệu bài viết từ bảng posts
$stmt = $db->prepare("SELECT * FROM posts WHERE id = :post_id");
$stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_ASSOC);

// Kiểm tra xem bài viết có tồn tại không
if (!$post) {
    die('Bài viết không tồn tại.');
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/styles.css">
    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            background-color: #343a40;
        }
        .navbar-brand {
            color: #ffffff !important;
        }
        .container {
            max-width: 800px;
            margin-top: 30px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        p {
            color: #555;
            line-height: 1.6;
        }
        .btn-success, .btn-secondary {
            border-radius: 20px;
            padding: 10px 20px;
        }
        .btn-success {
            background-color: #28a745;
            border: none;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .comment-section {
            margin-top: 30px;
            padding: 15px;
            background-color: #e9ecef;
            border-radius: 5px;
        }
        textarea {
            resize: none;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="/app/views/index.php">My Story Corner</a>
</nav>
<div class="container">
    <h1><?php echo htmlspecialchars($post['title']); ?></h1>
    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>

    <!-- Nút yêu thích -->
    <form action="/app/views/posts/like.php?id=<?php echo $post['id']; ?>" method="POST" class="d-inline">
        <button type="submit" class="btn btn-success">Yêu thích</button>
    </form>

    <!-- Hiển thị số lượt yêu thích -->
    <span class="ml-2"><?php echo isset($post['likes']) ? htmlspecialchars($post['likes']) : 0; ?> lượt yêu thích</span>

    <!-- Hiển thị bình luận -->
    <h6 class="mt-4">Bình luận:</h6>
    <div class="comment-section">
        <form action="/app/views/posts/comment.php?id=<?php echo $post['id']; ?>" method="POST">
            <div class="form-group">
                <textarea name="comment" class="form-control" placeholder="Nhập bình luận của bạn" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-secondary">Gửi bình luận</button>
        </form>
        <div class="mt-3">
            <?php 
            // Lấy bình luận cho bài viết này
            $comment_stmt = $db->prepare("SELECT * FROM comments WHERE post_id = :post_id");
            $comment_stmt->bindParam(':post_id', $post['id'], PDO::PARAM_INT);
            $comment_stmt->execute();
            $comments = $comment_stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($comments)): ?>
                <p>Chưa có bình luận nào.</p>
            <?php else: ?>
                <?php foreach ($comments as $comment): ?>
                    <p><strong><?php echo htmlspecialchars($comment['user_name']); ?>:</strong> <?php echo htmlspecialchars($comment['content']); ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Nút trở lại -->
    <a href="/app/views/posts/index.php" class="btn btn-secondary mt-4">Trở lại danh sách bài viết</a>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
