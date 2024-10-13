<?php
session_start();
require_once '../../config/config.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Kết nối đến cơ sở dữ liệu
$conn = connectDB();
$user_id = $_SESSION['user']['id'];

// Lấy thông tin người dùng từ cơ sở dữ liệu
$stmt = $conn->prepare("SELECT username, email, birth_place, birth_date, address, phone FROM users WHERE id = ?");
$stmt->bindParam(1, $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Xử lý cập nhật thông tin người dùng
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $birth_place = trim($_POST['birth_place']);
    $birth_date = trim($_POST['birth_date']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);

    $update_stmt = $conn->prepare("UPDATE users SET birth_place = ?, birth_date = ?, address = ?, phone = ? WHERE id = ?");
    $update_stmt->bindParam(1, $birth_place);
    $update_stmt->bindParam(2, $birth_date);
    $update_stmt->bindParam(3, $address);
    $update_stmt->bindParam(4, $phone);
    $update_stmt->bindParam(5, $user_id);
    
    if ($update_stmt->execute()) {
        $successMessage = "Thông tin của bạn đã được cập nhật thành công!";
        $user['birth_place'] = $birth_place;
        $user['birth_date'] = $birth_date;
        $user['address'] = $address;
        $user['phone'] = $phone;
    } else {
        $errorMessage = "Đã có lỗi xảy ra khi cập nhật thông tin!";
    }
    
    $update_stmt->closeCursor();
}

$stmt->closeCursor();
$conn = null;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> 
    <title>Hồ Sơ Người Dùng</title>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Hồ Sơ Của Tôi</h2>

    <?php if (isset($successMessage)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo htmlspecialchars($successMessage); ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($errorMessage)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($errorMessage); ?>
        </div>
    <?php endif; ?>

    <form action="profile.php" method="POST">
        <div class="form-group">
            <label for="username">Tên người dùng:</label>
            <input type="text" class="form-control" id="username" name="username" 
                   value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" 
                   value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="birth_place">Nơi sinh <span class="text-danger">*</span>:</label>
            <input type="text" class="form-control" id="birth_place" name="birth_place" 
                   value="<?php echo htmlspecialchars($user['birth_place'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="birth_date">Ngày sinh <span class="text-danger">*</span>:</label>
            <input type="date" class="form-control" id="birth_date" name="birth_date" 
                   value="<?php echo htmlspecialchars($user['birth_date'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="address">Địa chỉ:</label>
            <input type="text" class="form-control" id="address" name="address" 
                   value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="phone">Số điện thoại:</label>
            <input type="tel" class="form-control" id="phone" name="phone" 
                   value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
        </div>
        <button type="submit" class="btn btn-primary btn-block">Cập Nhật Thông Tin</button>
    </form>

    <div class="mt-3 text-center">
        <a href="logout.php">Đăng Xuất</a>
    </div>
</div>
</body>
</html>
