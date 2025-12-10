<?php
require_once __DIR__ . '/config/Database.php';

$db = Database::getInstance()->getConnection();

// Kiểm tra cấu trúc bảng enrollments
echo "<h2>Cấu trúc bảng enrollments:</h2>";
$sql = "DESCRIBE enrollments";
$result = $db->query($sql);
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "- " . $row['Field'] . " (" . $row['Type'] . ")<br>";
}

echo "<h2>Dữ liệu enrollments:</h2>";
$sql = "SELECT * FROM enrollments LIMIT 10";
$result = $db->query($sql);
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "<pre>" . print_r($row, true) . "</pre><br>";
}

echo "<h2>Kiểm tra enrollment của user hiện tại:</h2>";
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    echo "User ID: " . $userId . "<br>";
    
    $sql = "SELECT * FROM enrollments WHERE student_id = :user_id LIMIT 5";
    $stmt = $db->prepare($sql);
    $stmt->execute([':user_id' => $userId]);
    $enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($enrollments)) {
        echo "Không tìm thấy enrollment nào cho user này.";
    } else {
        foreach ($enrollments as $enrollment) {
            echo "<pre>" . print_r($enrollment, true) . "</pre><br>";
        }
    }
} else {
    echo "User chưa đăng nhập.";
}
?>
