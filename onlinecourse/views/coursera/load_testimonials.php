<?php
// Load testimonials from database
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/Review.php';

$reviewModel = new Review();

// Lấy đánh giá mới nhất từ database
$reviews = $reviewModel->getLatestReviews(6);

header('Content-Type: application/json');

if (empty($reviews)) {
    // Fallback: Tạo sample testimonials từ dữ liệu thật
    $db = Database::getInstance()->getConnection();
    
    // Lấy một vài học viên và khóa học thật để tạo sample
    $studentsSql = 'SELECT id, fullname FROM users WHERE role = 0 LIMIT 3';
    $studentsStmt = $db->query($studentsSql);
    $students = $studentsStmt->fetchAll(PDO::FETCH_ASSOC);
    
    $coursesSql = 'SELECT id, title FROM courses WHERE status = "approved" LIMIT 3';
    $coursesStmt = $db->query($coursesSql);
    $courses = $coursesStmt->fetchAll(PDO::FETCH_ASSOC);
    
    $sampleTestimonials = [];
    for ($i = 0; $i < min(3, count($students), count($courses)); $i++) {
        $sampleTestimonials[] = [
            'student_name' => $students[$i]['fullname'],
            'course_title' => $courses[$i]['title'],
            'comment' => 'Khóa học rất tuyệt vời! Nội dung chi tiết, giảng viên nhiệt tình.',
            'rating' => rand(4, 5)
        ];
    }
    
    // Format testimonials
    $formattedTestimonials = [];
    foreach ($sampleTestimonials as $testimonial) {
        $formattedTestimonials[] = [
            'name' => $testimonial['student_name'],
            'role' => 'Học viên khóa ' . $testimonial['course_title'],
            'text' => $testimonial['comment'],
            'rating' => $testimonial['rating']
        ];
    }
    
    echo json_encode($formattedTestimonials);
} else {
    // Format real reviews
    $formattedTestimonials = [];
    foreach ($reviews as $review) {
        $formattedTestimonials[] = [
            'name' => $review['fullname'],
            'role' => 'Học viên khóa ' . $review['course_title'],
            'text' => $review['comment'] ?? 'Khóa học rất tuyệt vời!',
            'rating' => $review['rating']
        ];
    }
    
    echo json_encode($formattedTestimonials);
}
?>
