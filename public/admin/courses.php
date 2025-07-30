<?php
require_once "../../src/auth.php";
requireRole('Admin');
require_once "../../config/database.php";
require_once "../../src/controllers/CourseController.php";

$courseController = new CourseController($link);
$courses = $courseController->getAllCourses();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Courses</title>
    <link rel="stylesheet" href="https://bootswatch.com/4/cerulean/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Manage Courses</h2>
        <a href="create_course.php" class="btn btn-success mb-3">Create New Course</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Teacher</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course): ?>
                <tr>
                    <td><?php echo $course['id']; ?></td>
                    <td><?php echo htmlspecialchars($course['title']); ?></td>
                    <td><?php echo htmlspecialchars($course['teacher_name']); ?></td>
                    <td>
                        <a href="edit_course.php?id=<?php echo $course['id']; ?>" class="btn btn-primary">Edit</a>
                        <a href="delete_course.php?id=<?php echo $course['id']; ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="../dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
</body>
</html>
