<?php
require_once "../../src/auth.php";
requireRole('Teacher');
require_once "../../config/database.php";
require_once "../../src/controllers/CourseController.php";

$courseController = new CourseController($link);
$courses = $courseController->getCoursesByTeacher($_SESSION['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Your Courses</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Manage Your Courses</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course): ?>
                <tr>
                    <td><?php echo $course['id']; ?></td>
                    <td><?php echo htmlspecialchars($course['title']); ?></td>
                    <td>
                        <a href="manage_lessons.php?course_id=<?php echo $course['id']; ?>" class="btn btn-primary">Manage Lessons</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="../dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
</body>
</html>
