<?php
require_once '../models/Post.php';
require_once '../models/Comment.php';

class PostController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Hiển thị danh sách bài viết
    public function index() {
        $post = new Post($this->db);
        $posts = $post->getAll(); // Lấy tất cả bài viết
        include '../views/posts/index.php'; // Bao gồm view danh sách bài viết
    }

    // Hiển thị chi tiết bài viết
    public function show($id) {
        $post = new Post($this->db);
        $postDetail = $post->getById($id); // Lấy bài viết theo ID
        
        $comment = new Comment($this->db);
        $comments = $comment->getByPostId($id); // Lấy bình luận của bài viết
        
        include '../views/posts/show.php'; // Bao gồm view chi tiết bài viết
    }

    // Tạo bài viết mới
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy dữ liệu từ form
            $user_id = $_POST['user_id']; // ID người dùng (cần phải xác thực)
            $title = $_POST['title'];
            $content = $_POST['content'];

            // Tạo bài viết mới
            $post = new Post($this->db);
            if ($post->create($user_id, $title, $content)) {
                // Redirect đến trang danh sách bài viết
                header("Location: /path/to/public/index.php/posts");
                exit(); // Dừng script để tránh tiếp tục chạy
            } else {
                // Hiển thị thông báo lỗi nếu tạo không thành công
                $errorMessage = "Có lỗi xảy ra khi tạo bài viết.";
            }
        }
        include '../views/posts/create.php'; // Bao gồm view tạo bài viết
    }
}
