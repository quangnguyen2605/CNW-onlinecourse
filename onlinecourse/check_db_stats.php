<?php
require_once 'config/Database.php';

$db = Database::getInstance()->getConnection();

echo "=== DATABASE STATISTICS ===\n\n";

// Check all users
$stmt = $db->query('SELECT role, COUNT(*) as count FROM users GROUP BY role');
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "Users by role:\n";
foreach ($users as $user) {
    echo "- {$user['role']}: {$user['count']}\n";
}

// Check all courses
$stmt = $db->query('SELECT status, COUNT(*) as count FROM courses GROUP BY status');
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "\nCourses by status:\n";
foreach ($courses as $course) {
    echo "- {$course['status']}: {$course['count']}\n";
}

// Check enrollments
$stmt = $db->query('SELECT COUNT(*) as count FROM enrollments');
$enrollments = $stmt->fetch(PDO::FETCH_ASSOC);
echo "\nTotal enrollments: {$enrollments['count']}\n";

// Check total counts
$stmt = $db->query('SELECT COUNT(*) as count FROM users WHERE role = "student"');
$students = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$stmt = $db->query('SELECT COUNT(*) as count FROM courses WHERE status = "approved"');
$approved_courses = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$stmt = $db->query('SELECT COUNT(*) as count FROM users WHERE role = "instructor"');
$instructors = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

echo "\n=== FINAL COUNTS ===\n";
echo "Students: $students\n";
echo "Approved Courses: $approved_courses\n";
echo "Instructors: $instructors\n";
echo "Enrollments: {$enrollments['count']}\n";
?>
