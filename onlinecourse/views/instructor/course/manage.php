<?php require __DIR__ . '/../../layouts/header.php'; ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-graduation-cap"></i> Quản lý khóa học của tôi
                </h2>
                <a href="/onlinecourse/onlinecourse/index.php?controller=Course&action=create" 
                   class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tạo khóa học mới
                </a>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h4><?= count($courses) ?></h4>
                            <p class="mb-0">Tổng khóa học</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h4><?= array_sum(array_column($courses, 'student_count')) ?></h4>
                            <p class="mb-0">Tổng học viên</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h4><?= array_sum(array_column($courses, 'lesson_count')) ?></h4>
                            <p class="mb-0">Tổng bài học</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <h4><?= array_sum(array_column($courses, 'material_count')) ?></h4>
                            <p class="mb-0">Tổng tài liệu</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Courses List -->
            <?php if (!empty($courses)): ?>
                <div class="row">
                    <?php foreach ($courses as $course): ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100">
                                <?php if ($course['image']): ?>
                                    <img src="<?= htmlspecialchars($course['image']) ?>" class="card-img-top" 
                                         alt="<?= htmlspecialchars($course['title']) ?>" style="height: 200px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="card-img-top d-flex align-items-center justify-content-center bg-light" 
                                         style="height: 200px;">
                                        <i class="fas fa-graduation-cap fa-3x text-muted"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?= htmlspecialchars($course['title']) ?></h5>
                                    <p class="card-text text-muted">
                                        <?= htmlspecialchars(substr($course['description'], 0, 100)) ?>...
                                    </p>
                                    
                                    <div class="mb-3">
                                        <small class="text-muted">
                                            <i class="fas fa-users"></i> <?= (int)($course['student_count'] ?? 0) ?> học viên
                                            <br>
                                            <i class="fas fa-book"></i> <?= (int)($course['lesson_count'] ?? 0) ?> bài học
                                            <br>
                                            <i class="fas fa-file"></i> <?= (int)($course['material_count'] ?? 0) ?> tài liệu
                                        </small>
                                    </div>
                                    
                                    <div class="mt-auto">
                                        <div class="btn-group w-100" role="group">
                                            <a href="/onlinecourse/onlinecourse/index.php?controller=Course&action=edit&id=<?= $course['id'] ?>" 
                                               class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-edit"></i> Sửa
                                            </a>
                                            <a href="/onlinecourse/onlinecourse/index.php?controller=Lesson&action=manage&course_id=<?= $course['id'] ?>" 
                                               class="btn btn-outline-success btn-sm">
                                                <i class="fas fa-book"></i> Bài học
                                            </a>
                                            <a href="/onlinecourse/onlinecourse/index.php?controller=Instructor&action=uploadCourseMaterials&course_id=<?= $course['id'] ?>" 
                                               class="btn btn-outline-info btn-sm">
                                                <i class="fas fa-upload"></i> Tài liệu
                                            </a>
                                        </div>
                                        
                                        <div class="btn-group w-100 mt-2" role="group">
                                            <a href="/onlinecourse/onlinecourse/index.php?controller=Instructor&action=viewStudents&course_id=<?= $course['id'] ?>" 
                                               class="btn btn-outline-secondary btn-sm">
                                                <i class="fas fa-users"></i> Học viên
                                            </a>
                                            <a href="/onlinecourse/onlinecourse/index.php?controller=Course&action=detail&id=<?= $course['id'] ?>" 
                                               class="btn btn-outline-dark btn-sm">
                                                <i class="fas fa-eye"></i> Xem khóa học
                                            </a>
                                            <a href="/onlinecourse/onlinecourse/index.php?controller=Course&action=delete&id=<?= $course['id'] ?>" 
                                               class="btn btn-outline-danger btn-sm"
                                               onclick="return confirm('Bạn có chắc muốn xóa khóa học này?')">
                                                <i class="fas fa-trash"></i> Xóa
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-3x mb-3"></i>
                    <h4>Bạn chưa có khóa học nào</h4>
                    <p>Hãy tạo khóa học đầu tiên để bắt đầu giảng dạy.</p>
                    <a href="/onlinecourse/onlinecourse/index.php?controller=Course&action=create" 
                       class="btn btn-primary btn-lg">
                        <i class="fas fa-plus"></i> Tạo khóa học đầu tiên
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>