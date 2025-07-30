<?php
require_once "../../src/auth.php";
requireRole('Student');
require_once "../../config/database.php";
require_once "../../src/controllers/CourseController.php";
require_once "../../src/controllers/EnrollmentController.php";

$courseController = new CourseController($link);
$enrollmentController = new EnrollmentController($link);

$courses = $courseController->getAllCourses();
$enrolled_courses = $enrollmentController->getEnrolledCoursesByStudent($_SESSION['id']);
$enrolled_course_ids = array_column($enrolled_courses, 'course_id');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Browse Courses</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Browse Courses</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Teacher</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course): ?>
                <tr>
                    <td><?php echo htmlspecialchars($course['title']); ?></td>
                    <td><?php echo htmlspecialchars($course['description']); ?></td>
                    <td><?php echo htmlspecialchars($course['teacher_name']); ?></td>
                    <td>
                        <?php if (in_array($course['id'], $enrolled_course_ids)): ?>
                            <a href="view_course.php?id=<?php echo $course['id']; ?>" class="btn btn-info">View Course</a>
                        <?php else: ?>
                            <a href="enroll.php?course_id=<?php echo $course['id']; ?>" class="btn btn-success">Enroll</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="../dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
</body>
</html>
