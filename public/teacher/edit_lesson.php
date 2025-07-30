<?php
require_once "../../src/auth.php";
requireRole('Teacher');
require_once "../../config/database.php";
require_once "../../src/controllers/LessonController.php";
require_once "../../src/controllers/CourseController.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("location: courses.php");
    exit;
}

$lesson_id = $_GET['id'];
$lessonController = new LessonController($link);
$courseController = new CourseController($link);

$lesson = $lessonController->getLessonById($lesson_id);
$course = $courseController->getCourseById($lesson['course_id']);

// Ensure the teacher owns the course
if ($course['teacher_id'] != $_SESSION['id']) {
    header("location: courses.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if ($lessonController->updateLesson($lesson_id, $title, $content)) {
        header("location: manage_lessons.php?course_id=" . $lesson['course_id']);
    } else {
        echo "Something went wrong. Please try again later.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Lesson</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Edit Lesson</h2>
        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($lesson['title']); ?>" required>
            </div>
            <div class="form-group">
                <label>Content</label>
                <textarea name="content" class="form-control" rows="10" required><?php echo htmlspecialchars($lesson['content']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Lesson</button>
            <a href="manage_lessons.php?course_id=<?php echo $lesson['course_id']; ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
