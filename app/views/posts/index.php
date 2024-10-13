<?php
require_once '../../config/database.php';

// Tạo đối tượng Database và lấy kết nối
$database = new Database();
$db = $database->getConnection();

// Lấy dữ liệu từ bảng posts
$stmt = $db->query("SELECT * FROM posts");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài Viết</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/styles.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            color: #343a40;
        }
        .navbar {
            background-color: #343a40;
            padding: 15px;
        }
        .navbar-brand, .nav-link {
            color: white !important;
            font-size: 1.2rem;
            text-transform: uppercase;
        }
        .container {
            margin-top: 50px;
            max-width: 900px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        .card-title {
            font-size: 1.75rem;
            color: #007bff;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-success {
            background-color: #28a745;
            border: none;
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .btn-info {
            background-color: #17a2b8;
            border: none;
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .btn-info:hover {
            background-color: #138496;
        }
        .comment-section {
            background-color: #e9ecef;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        textarea {
            resize: none;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding: 20px 0;
            background-color: #343a40;
            color: white;
            border-top: 1px solid #e1e1e1;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="/app/views/index.php">My Story Corner</a>
</nav>
<div class="container">
    <h1 class="text-center mb-4">Bài Viết</h1>
    <a href="/app/views/posts/create.php" class="btn btn-lg btn-success mb-3">Tạo Bài Viết Mới</a>
    <?php if (!empty($posts) && is_array($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars(substr($post['content'], 0, 100)) . '...'; ?></p>
                    <a href="/app/views/posts/view.php?id=<?php echo $post['id']; ?>" class="btn btn-primary">Đọc thêm</a>
                    <form action="/app/views/posts/like.php?id=<?php echo $post['id']; ?>" method="POST" class="d-inline">
                        <button type="submit" class="btn btn-success">Yêu thích</button>
                    </form>
                    <span><?php echo isset($post['likes']) ? htmlspecialchars($post['likes']) : 0; ?> lượt yêu thích</span>
                    <button class="btn btn-info mt-2" data-toggle="collapse" data-target="#comments-<?php echo $post['id']; ?>">Bình luận</button>
                    <div id="comments-<?php echo $post['id']; ?>" class="collapse comment-section mt-2">
                        <form action="/app/views/posts/comment.php?id=<?php echo $post['id']; ?>" method="POST">
                            <div class="form-group">
                                <textarea name="comment" class="form-control" placeholder="Nhập bình luận của bạn" rows="2" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-secondary">Gửi bình luận</button>
                        </form>
                        <div class="mt-3">
                            <h6>Bình luận:</h6>
                            <?php
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
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Không có bài viết nào để hiển thị.</p>
    <?php endif; ?>
</div>
<footer class="footer">
    <p>&copy; <?php echo date("Y"); ?> My Story Corner. Tất cả quyền được bảo lưu.</p>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
