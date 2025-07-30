<?php
require_once "../../src/auth.php";
requireRole('Teacher');
require_once "../../config/database.php";
require_once "../../src/controllers/LessonController.php";
require_once "../../src/controllers/CourseController.php";

if (!isset($_GET['course_id']) || empty($_GET['course_id'])) {
    header("location: courses.php");
    exit;
}

$course_id = $_GET['course_id'];
$lessonController = new LessonController($link);
$courseController = new CourseController($link);

// Ensure the teacher owns the course
$course = $courseController->getCourseById($course_id);
if ($course['teacher_id'] != $_SESSION['id']) {
    header("location: courses.php");
    exit;
}

$lessons = $lessonController->getLessonsByCourse($course_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Lessons</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Manage Lessons for <?php echo htmlspecialchars($course['title']); ?></h2>
        <a href="create_lesson.php?course_id=<?php echo $course_id; ?>" class="btn btn-success mb-3">Create New Lesson</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lessons as $lesson): ?>
                <tr>
                    <td><?php echo $lesson['id']; ?></td>
                    <td><?php echo htmlspecialchars($lesson['title']); ?></td>
                    <td>
                        <a href="edit_lesson.php?id=<?php echo $lesson['id']; ?>" class="btn btn-primary">Edit</a>
                        <a href="delete_lesson.php?id=<?php echo $lesson['id']; ?>&course_id=<?php echo $course_id; ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="courses.php" class="btn btn-secondary">Back to Courses</a>
    </div>
</body>
</html>
