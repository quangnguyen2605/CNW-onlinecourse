<?php
// Test password hash
$password = '123456';
$hash = password_hash('123456', PASSWORD_DEFAULT);

echo "Password: $password<br>";
echo "Hash: $hash<br>";
echo "Verify result: " . (password_verify($password, $hash) ? 'SUCCESS' : 'FAILED') . "<br>";

// Test database connection
try {
    $db = new PDO("mysql:host=localhost;dbname=onlinecourse", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Test user lookup
    $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => 'admin123@course.com']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<br>Database connection: SUCCESS<br>";
    echo "User found: " . ($user ? 'YES' : 'NO') . "<br>";
    if ($user) {
        echo "User role: " . $user['role'] . "<br>";
        echo "Password verify: " . (password_verify($password, $user['password']) ? 'SUCCESS' : 'FAILED') . "<br>";
    }
} catch (Exception $e) {
    echo "Database error: " . $e->getMessage();
}
?>