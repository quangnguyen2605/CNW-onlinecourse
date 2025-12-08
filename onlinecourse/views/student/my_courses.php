<?php require __DIR__ . '/../layouts/header.php'; ?>
<div class="my-courses">
    <h2>Khóa học của tôi</h2>
    <div class="course-list">
        <?php if (isset($courses) && !empty($courses)): ?>
            <?php foreach ($courses as $c): ?>
                <div class="course-card">
                    <h3><?= htmlspecialchars($c['title']) ?></h3>
                    <p>Trạng thái: <?= htmlspecialchars($c['status']) ?></p>
                    <p>Tiến độ: <?= (int)$c['progress'] ?>%</p>
                    <div class="d-flex gap-2">
                        <a class="btn btn-primary" href="/onlinecourse/onlinecourse/index.php?controller=Enrollment&action=progress&course_id=<?= $c['course_id'] ?>">Xem chi tiết tiến độ</a>
                        <?php 
                        // Get first lesson of this course
                        $lessonModel = new Lesson();
                        $firstLesson = $lessonModel->getByCourse($c['course_id']);
                        if (!empty($firstLesson)):
                            $firstLessonId = $firstLesson[0]['id'];
                        ?>
                            <a class="btn btn-success" href="/onlinecourse/onlinecourse/index.php?controller=Student&action=viewLesson&lesson_id=<?= $firstLessonId ?>">
                                <i class="fas fa-play"></i> Học bài học
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Bạn chưa đăng ký khóa học nào.
                <a href="/onlinecourse/onlinecourse/index.php?controller=Course&action=index" class="btn btn-primary ms-2">Xem khóa học</a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
