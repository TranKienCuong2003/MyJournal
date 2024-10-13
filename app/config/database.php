<?php
// Tải autoload để sử dụng các thư viện bên ngoài
require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;

class Database {
    private $connection;

    public function __construct() {
        // Tải file .env từ thư mục gốc của dự án
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        // Lấy thông tin từ file .env
        $host = $_ENV['DB_HOST'];
        $dbname = $_ENV['DB_NAME'];
        $username = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASS'];

        try {
            // Kết nối tới cơ sở dữ liệu
            $this->connection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Kết nối không thành công: " . $e->getMessage());
        }
    }

    // Hàm để lấy kết nối
    public function getConnection() {
        return $this->connection;
    }
}

// Kiểm tra file .env có tồn tại không
if (!file_exists(__DIR__ . '/../../.env')) {
    die('File .env không tồn tại!');
}
