<?php
// Load categories with real course counts from database
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/Category.php';
require_once __DIR__ . '/../../models/Course.php';

$db = Database::getInstance()->getConnection();

// Get all categories with course counts
$sql = 'SELECT c.*, COUNT(co.id) as course_count 
        FROM categories c 
        LEFT JOIN courses co ON c.id = co.category_id AND co.status = "approved"
        GROUP BY c.id 
        HAVING course_count > 0
        ORDER BY course_count DESC, c.name';
$stmt = $db->query($sql);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Define icons for each category
$categoryIcons = [
    'Lập trình Web' => 'fa-code',
    'Lập trình Mobile' => 'fa-mobile-alt',
    'Data Science' => 'fa-chart-bar',
    'UI/UX Design' => 'fa-paint-brush',
    'Database' => 'fa-database',
    'Lập trình' => 'fa-laptop-code',
    'Thiết kế' => 'fa-palette',
    // Default icon
    'default' => 'fa-book'
];

// Format categories for JSON response
$formattedCategories = [];
foreach ($categories as $category) {
    $formattedCategories[] = [
        'id' => $category['id'],
        'name' => $category['name'],
        'count' => (int)$category['course_count'],
        'icon' => $categoryIcons[$category['name']] ?? $categoryIcons['default']
    ];
}

// Limit to 8 categories for better display
$formattedCategories = array_slice($formattedCategories, 0, 8);

header('Content-Type: application/json');
echo json_encode($formattedCategories);
?>
