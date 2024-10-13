<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($postDetail['title']); ?></title>
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
                <a class="nav-link" href="/path/to/public/index.php/posts/create">Tạo Bài Viết</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container mt-4">
    <h1><?php echo htmlspecialchars($postDetail['title']); ?></h1>
    <p><?php echo nl2br(htmlspecialchars($postDetail['content'])); ?></p>

    <h3>Bình Luận</h3>
    
    <!-- Biểu mẫu thêm bình luận -->
    <form method="POST" action="add_comment.php">
        <div class="form-group">
            <label for="user_name">Tên của bạn:</label>
            <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Nhập tên của bạn" required>
        </div>
        <div class="form-group">
            <label for="comment">Nội dung bình luận:</label>
            <textarea class="form-control" id="comment" name="content" required></textarea>
        </div>
        <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($postDetail['id']); ?>"> <!-- ID bài viết -->
        <button type="submit" class="btn btn-primary">Gửi Bình Luận</button>
    </form>

    <!-- Hiển thị bình luận -->
    <div class="mt-3">
        <?php foreach ($comments as $comment): ?>
            <div class="alert alert-secondary">
                <strong><?php echo htmlspecialchars($comment['user_name']); ?>:</strong>
                <p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                <small class="text-muted">Bình luận vào <?php echo htmlspecialchars($comment['created_at']); ?></small>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
