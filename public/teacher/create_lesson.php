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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $video_url = trim($_POST['video_url']);

    if ($lessonController->createLesson($course_id, $title, $content, $video_url)) {
        header("location: manage_lessons.php?course_id=" . $course_id);
    } else {
        echo "Something went wrong. Please try again later.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Lesson</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Create New Lesson</h2>
        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Content</label>
                <textarea name="content" class="form-control" rows="10" required></textarea>
            </div>
            <div class="form-group">
                <label>YouTube Video URL</label>
                <input type="text" name="video_url" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Create Lesson</button>
            <a href="manage_lessons.php?course_id=<?php echo $course_id; ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
