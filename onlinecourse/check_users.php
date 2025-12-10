<?php
require_once 'config/Database.php';

$db = Database::getInstance()->getConnection();
$stmt = $db->query('DESCRIBE users');
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Users table columns:\n";
foreach($columns as $col) {
    echo $col['Field'] . "\n";
}
?>
