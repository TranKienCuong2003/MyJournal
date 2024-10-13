<?php
session_start();
require_once '../../config/config.php';

$errorMessage = "";

// Xử lý đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Kết nối đến cơ sở dữ liệu
    $conn = connectDB();

    // Chuẩn bị câu lệnh SQL để lấy thông tin người dùng
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bindParam(1, $username);
    $stmt->execute();

    // Kiểm tra xem người dùng có tồn tại không
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Kiểm tra mật khẩu
        if (password_verify($password, $user['password'])) {
            // Lưu thông tin người dùng vào session
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
            ];

            // Chuyển hướng đến trang chính của website
            header("Location: /app/views/index.php");
            exit();
        } else {
            $errorMessage = "Mật khẩu không đúng!";
        }
    } else {
        $errorMessage = "Tên đăng nhập không tồn tại!";
    }

    // Đóng kết nối
    $stmt->closeCursor();
    $conn = null;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Đăng Nhập</title>
    <style>
        #errorAlert {
            display: none; /* Ẩn thông báo mặc định */
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Đăng Nhập</h2>

    <?php if (!empty($errorMessage)): ?>
        <div id="errorAlert" class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($errorMessage); ?>
        </div>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" class="form-control" id="username" name="username" 
                   value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" 
                   required>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Đăng Nhập</button>
    </form>

    <div class="mt-3 text-center">
        <?php if (isset($_SESSION['user'])): ?>
            <a href="profile.php">Hồ Sơ</a> | 
            <a href="logout.php">Đăng Xuất</a>
        <?php else: ?>
            <a href="register.php">Bạn chưa có tài khoản? Đăng ký ngay!</a>
        <?php endif; ?>
    </div>
</div>

<!-- Optional JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Hiển thị thông báo lỗi nếu có
    <?php if (!empty($errorMessage)): ?>
        document.getElementById("errorAlert").style.display = "block";
        // Ẩn thông báo sau 3 giây
        setTimeout(function() {
            document.getElementById("errorAlert").style.display = "none";
        }, 3000);
    <?php endif; ?>
</script>
</body>
</html>
