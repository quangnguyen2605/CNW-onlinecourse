<?php
require_once __DIR__ . '/config/Database.php';

$db = Database::getInstance()->getConnection();

// Tạo bảng reviews
$sql = "CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    UNIQUE KEY unique_review (user_id, course_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

try {
    $db->exec($sql);
    echo "Bảng reviews đã được tạo thành công!\n";
    
    // Kiểm tra xem bảng đã có dữ liệu chưa
    $countSql = "SELECT COUNT(*) as count FROM reviews";
    $result = $db->query($countSql);
    $count = $result->fetch(PDO::FETCH_ASSOC)['count'];
    
    echo "Số lượng reviews hiện tại: " . $count . "\n";
    
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage() . "\n";
}
?>
