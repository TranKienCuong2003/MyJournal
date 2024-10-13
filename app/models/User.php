<?php
class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Đăng ký người dùng
    public function register($username, $password) {
        // Kiểm tra xem tên người dùng đã tồn tại hay chưa
        if ($this->usernameExists($username)) {
            return false; // Tên người dùng đã tồn tại
        }

        // Mã hóa mật khẩu
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        return $stmt->execute([$username, $hashedPassword]);
    }

    // Kiểm tra tên người dùng có tồn tại không
    private function usernameExists($username) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetchColumn() > 0;
    }

    // Đăng nhập người dùng
    public function login($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Kiểm tra mật khẩu
        if ($user && password_verify($password, $user['password'])) {
            return $user; // Đăng nhập thành công, trả về thông tin người dùng
        }
        return false; // Đăng nhập thất bại
    }
}
