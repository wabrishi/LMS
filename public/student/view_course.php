<?php
require_once "../../src/auth.php";
requireRole('Student');
require_once "../../config/database.php";
require_once "../../src/controllers/CourseController.php";
require_once "../../src/controllers/LessonController.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("location: courses.php");
    exit;
}

$courseController = new CourseController($link);
$lessonController = new LessonController($link);

$course_id = $_GET['id'];
$course = $courseController->getCourseById($course_id);
$lessons = $lessonController->getLessonsByCourse($course_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($course['title']); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-5"><?php echo htmlspecialchars($course['title']); ?></h2>
        <p><?php echo htmlspecialchars($course['description']); ?></p>
        <hr>
        <h3>Lessons</h3>
        <div class="list-group">
            <?php foreach ($lessons as $lesson): ?>
                <a href="#" class="list-group-item list-group-item-action">
                    <?php echo htmlspecialchars($lesson['title']); ?>
                </a>
            <?php endforeach; ?>
        </div>
        <a href="courses.php" class="btn btn-secondary mt-3">Back to Courses</a>
    </div>
</body>
</html>
