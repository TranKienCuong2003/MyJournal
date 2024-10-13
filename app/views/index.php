<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Story Corner - Nơi chia sẻ những câu chuyện</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">My Story Corner</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <!-- Kiểm tra xem người dùng đã đăng nhập chưa -->
                <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/app/views/users/profile.php">
                            <i class="fas fa-user"></i> Hồ Sơ
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo htmlspecialchars($_SESSION['user']['username']); ?> <!-- Hiển thị tên người dùng -->
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="/app/views/users/logout.php">
                                <i class="fas fa-sign-out-alt"></i> Đăng Xuất
                            </a>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/app/views/users/login.php">
                            <i class="fas fa-sign-in-alt"></i> Đăng Nhập
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/app/views/users/register.php">
                            <i class="fas fa-user-plus"></i> Đăng Ký
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>


    <div class="container mt-5 mb-5">
        <div class="hero shadow-lg p-5 text-center">
            <h1 class="display-4">Chào Mừng Bạn Đã Đén Với My Story Corner</h1>
            <p class="lead">Chia sẻ những suy nghĩ và trải nghiệm của chính bản thân bạn!</p>
            <a href="/app/views/posts/create.php" class="btn btn-lg btn-primary mt-3 shadow">Tạo Bài Viết Mới</a>
            <img src="https://source.unsplash.com/400x300/?journal,writing" 
                 alt="Writing" class="img-fluid position-absolute" 
                 style="bottom: -30px; right: -30px; border-radius: 12px;">
        </div>

        <!-- Phần hiển thị thông tin người dùng nếu đã đăng nhập -->
        <?php if (isset($_SESSION['user'])): ?>
            <div class="alert alert-info text-center">
                <h4 class="alert-heading">Xin chào, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>!</h4>
                <p>Cảm ơn bạn đã quay lại với My Story Corner. Bạn có thể tạo bài viết mới hoặc xem các bài viết đã có ngay!</p>
            </div>
        <?php endif; ?>

        <div class="featurette mt-5 p-4 bg-light rounded shadow-sm">
            <h2 class="text-center mb-4">Khám Phá</h2>
            <div class="row">
                <div class="col-md-6 text-center">
                    <a href="/app/views/posts/index.php" class="btn btn-primary btn-lg w-75">
                        <i class="fas fa-list-alt"></i> Xem Bài Viết
                    </a>
                </div>
                <div class="col-md-6 text-center">
                    <a href="/app/views/posts/create.php" class="btn btn-success btn-lg w-75">
                        <i class="fas fa-plus-circle"></i> Tạo Bài Viết
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <h3>Khám Phá Nội Dung Mới Nhất</h3>
            <p>Hãy tham gia cộng đồng và chia sẻ ý tưởng của bạn cùng chúng tôi!</p>
        </div>
    </div>

    <footer class="footer bg-dark text-white py-3">
        <div class="container text-center">
            <p class="mb-1">&copy; 2024 My Story Corner. Tất cả các quyền được bảo lưu.</p>
            <p>Theo dõi chúng tôi:
                <a href="#" class="text-white ml-2"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-white ml-2"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-white ml-2"><i class="fab fa-instagram"></i></a>
            </p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
