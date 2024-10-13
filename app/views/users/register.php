<?php
require_once '../../config/config.php';

$errorMessage = "";
$successMessage = "";

// Kết nối đến cơ sở dữ liệu
$conn = connectDB();

// Xử lý đăng ký
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Kiểm tra mật khẩu xác nhận
    if ($password !== $confirm_password) {
        $errorMessage = "Mật khẩu không khớp!";
    } else {
        // Mã hóa mật khẩu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Chuẩn bị câu lệnh SQL
        $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $hashed_password);
        $stmt->bindParam(3, $email);

        // Thực thi câu lệnh
        if ($stmt->execute()) {
            $successMessage = "Đăng ký thành công! Bạn sẽ được chuyển hướng đến trang đăng nhập.";
        } else {
            $errorMessage = "Đăng ký thất bại: " . $stmt->errorInfo()[2];
        }

        // Đóng câu lệnh
        $stmt->closeCursor();
    }
}

// Đóng kết nối (tùy chọn, PDO sẽ tự động đóng kết nối khi script kết thúc)
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Đăng Ký</title>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Đăng Ký</h2>

    <?php if ($errorMessage): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errorMessage; ?>
        </div>
    <?php elseif ($successMessage): ?>
        <div class="alert alert-success" role="alert" id="successAlert">
            <?php echo $successMessage; ?>
        </div>
        <script>
            // Tự động chuyển hướng sau 2 giây
            setTimeout(function() {
                window.location.href = '../users/login.php';
            }, 2000);
        </script>
    <?php endif; ?>

    <form action="register.php" method="POST">
        <div class="form-group">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Xác nhận mật khẩu:</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Đăng Ký</button>
    </form>

    <div class="mt-3 text-center">
        <a href="login.php">Bạn đã có tài khoản? Đăng nhập ngay!</a>
    </div>
</div>

<!-- Optional JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
