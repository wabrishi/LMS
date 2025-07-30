<?php
require_once "../../src/auth.php";
requireRole('Admin');
require_once "../../config/database.php";
require_once "../../src/controllers/CourseController.php";

$courseController = new CourseController($link);

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("location: courses.php");
    exit;
}

$course_id = $_GET['id'];
$course = $courseController->getCourseById($course_id);
$teachers = $courseController->getAllTeachers();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $teacher_id = trim($_POST['teacher_id']);

    if ($courseController->updateCourse($course_id, $title, $description, $teacher_id)) {
        header("location: courses.php");
    } else {
        echo "Something went wrong. Please try again later.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Course</title>
    <link rel="stylesheet" href="https://bootswatch.com/4/cerulean/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Edit Course</h2>
        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($course['title']); ?>" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="5" required><?php echo htmlspecialchars($course['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label>Teacher</label>
                <select name="teacher_id" class="form-control" required>
                    <option value="">Select a teacher</option>
                    <?php foreach ($teachers as $teacher): ?>
                        <option value="<?php echo $teacher['id']; ?>" <?php echo ($teacher['id'] == $course['teacher_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($teacher['username']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Course</button>
            <a href="courses.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
