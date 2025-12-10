<?php
// Load courses from database
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/Course.php';
require_once __DIR__ . '/../../models/Category.php';

$courseModel = new Course();
$categoryModel = new Category();

// Get only approved courses for public display (limit to 6)
$courses = $courseModel->getAllApproved();
$courses = array_slice($courses, 0, 6); // Limit to 6 courses

// Format courses for JSON response
$formattedCourses = [];
foreach ($courses as $course) {
    // Get category name
    $category = $categoryModel->findById($course['category_id']);
    $categoryName = $category ? $category['name'] : 'Khác';
    
    // Format image path
    $imagePath = $course['image'];
    if (empty($imagePath)) {
        // Use default images based on category
        $defaultImages = [
            '1' => '/onlinecourse/onlinecourse/assets/images/course-defaults/programming.jpg',
            '2' => '/onlinecourse/onlinecourse/assets/images/course-defaults/design.jpg', 
            '3' => '/onlinecourse/onlinecourse/assets/images/course-defaults/business.jpg',
            '4' => '/onlinecourse/onlinecourse/assets/images/course-defaults/language.jpg'
        ];
        $imagePath = $defaultImages[$course['category_id']] ?? 'https://via.placeholder.com/400x300/6366f1/ffffff?text=Khóa+học';
    } elseif (!str_starts_with($imagePath, 'http') && !str_starts_with($imagePath, '/')) {
        $imagePath = '/onlinecourse/onlinecourse/' . $imagePath;
    } elseif (str_starts_with($imagePath, 'assets/')) {
        $imagePath = '/onlinecourse/onlinecourse/' . $imagePath;
    }
    
    $formattedCourses[] = [
        'id' => $course['id'],
        'title' => $course['title'],
        'category' => $categoryName,
        'instructor' => $course['instructor_name'] ?? 'Giảng viên',
        'rating' => 4.5 + (rand(0, 8) / 10), // Random rating between 4.5-5.0
        'ratingCount' => rand(100, 2000),
        'price' => $course['price'],
        'originalPrice' => $course['price'] > 0 ? $course['price'] * 1.5 : 0,
        'badge' => 'Phổ biến',
        'image' => $imagePath
    ];
}

header('Content-Type: application/json');
echo json_encode($formattedCourses);
?>
