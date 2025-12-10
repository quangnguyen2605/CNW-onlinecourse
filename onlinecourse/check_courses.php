<?php
require_once 'config/Database.php';
require_once 'models/Course.php';

$courseModel = new Course();
$courses = $courseModel->getAllApproved();

echo 'Found ' . count($courses) . ' approved courses\n';
foreach($courses as $course) {
    echo 'Course: ' . $course['title'] . ' - Image: ' . ($course['image'] ?? 'NULL') . '\n';
}
?>
