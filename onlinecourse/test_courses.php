<?php
require_once 'config/Database.php';

$db = Database::getInstance()->getConnection();

echo "=== Course Status Check ===\n";

// Check pending courses
$result = $db->query('SELECT COUNT(*) as count FROM courses WHERE status = "pending"');
$count = $result->fetch(PDO::FETCH_ASSOC)['count'];
echo "Pending courses: " . $count . "\n";

// Show all courses with status
$result = $db->query('SELECT id, title, status FROM courses ORDER BY created_at DESC LIMIT 10');
echo "\nRecent courses:\n";
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "ID: {$row['id']}, Title: {$row['title']}, Status: {$row['status']}\n";
}

// Check if you need to create a pending course for testing
if ($count == 0) {
    echo "\nNo pending courses found. Creating a test pending course...\n";
    $stmt = $db->prepare('INSERT INTO courses (title, description, instructor_id, status, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())');
    $stmt->execute(['Test Pending Course', 'This is a test course for approval', 1, 'pending']);
    echo "Test pending course created.\n";
}
?>
