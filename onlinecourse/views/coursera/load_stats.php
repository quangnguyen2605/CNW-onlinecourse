<?php
// Load real statistics from database
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/Course.php';
require_once __DIR__ . '/../../models/User.php';

$db = Database::getInstance()->getConnection();

// Get total students count (role = 0)
$stmt = $db->query('SELECT COUNT(*) as total FROM users WHERE role = 0');
$studentCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Get total courses count (approved courses only)
$stmt = $db->query('SELECT COUNT(*) as total FROM courses WHERE status = "approved"');
$courseCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Get total instructors count (role = 1)
$stmt = $db->query('SELECT COUNT(*) as total FROM users WHERE role = 1');
$instructorCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Get total enrollments count
$stmt = $db->query('SELECT COUNT(*) as total FROM enrollments');
$enrollmentCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Calculate satisfaction rate (mock data for now)
$satisfactionRate = 95; // 95%

$stats = [
    'students' => (int)$studentCount,
    'courses' => (int)$courseCount,
    'instructors' => (int)$instructorCount,
    'enrollments' => (int)$enrollmentCount,
    'satisfaction' => (int)$satisfactionRate
];

header('Content-Type: application/json');
echo json_encode($stats);
?>
