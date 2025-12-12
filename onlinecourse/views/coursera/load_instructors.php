<?php
// Load instructors from database
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/User.php';

header('Content-Type: application/json');

try {
    $userModel = new User();
    $instructors = $userModel->getInstructors();
    
    if (!empty($instructors)) {
        // Format instructors for JSON response
        $formattedInstructors = [];
        
        foreach ($instructors as $instructor) {
            $formattedInstructors[] = [
                'id' => $instructor['id'],
                'name' => $instructor['fullname'],
                'email' => $instructor['email'],
                'specialization' => $instructor['specialization'] ?? 'Chuyên gia',
                'bio' => $instructor['bio'] ?? 'Giảng viên chuyên môn cao',
                'avatar' => $instructor['avatar'] ?: null  // Return null if no avatar in database
            ];
        }
        
        echo json_encode([
            'success' => true,
            'instructors' => $formattedInstructors
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Không tìm thấy giảng viên nào'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Lỗi khi tải giảng viên: ' . $e->getMessage()
    ]);
}
?>
