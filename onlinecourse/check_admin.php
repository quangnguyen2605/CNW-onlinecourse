<?php
require_once 'config/Database.php';

$db = Database::getInstance()->getConnection();

echo "=== User Role Check ===\n";

// Check current admin users
$result = $db->query('SELECT id, username, fullname, role FROM users WHERE role = 2');
$admins = $result->fetchAll(PDO::FETCH_ASSOC);

echo "Admin users (role = 2):\n";
if (empty($admins)) {
    echo "No admin users found.\n";
    
    // Show all users with their roles
    $result = $db->query('SELECT id, username, fullname, role FROM users ORDER BY role DESC');
    echo "\nAll users:\n";
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $roleName = ['Học viên', 'Giảng viên', 'Quản trị viên'][$row['role']] ?? 'Unknown';
        echo "ID: {$row['id']}, Username: {$row['username']}, Role: {$row['role']} ($roleName)\n";
    }
} else {
    foreach ($admins as $admin) {
        echo "ID: {$admin['id']}, Username: {$admin['username']}, Name: {$admin['fullname']}\n";
    }
}

echo "\nTo test admin functionality, you need to:\n";
echo "1. Log in as an admin user (role = 2)\n";
echo "2. Or update an existing user to role = 2\n";
echo "3. Then access: /onlinecourse/onlinecourse/index.php?controller=Admin&action=pendingCourses\n";
?>
