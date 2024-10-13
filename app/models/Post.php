<?php
class Post {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Tạo bài viết mới
    public function create($user_id, $title, $content) {
        $stmt = $this->db->prepare("INSERT INTO posts (user_id, title, content, created_at) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$user_id, $title, $content]);
    }

    // Lấy tất cả bài viết
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM posts ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy bài viết theo ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
