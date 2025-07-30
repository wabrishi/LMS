<?php
require_once "../../src/auth.php";
requireRole('Teacher');
require_once "../../config/database.php";
require_once "../../src/controllers/LessonController.php";
require_once "../../src/controllers/CourseController.php";

if (!isset($_GET['id']) || empty($_GET['id']) || !isset($_GET['course_id']) || empty($_GET['course_id'])) {
    header("location: courses.php");
    exit;
}

$lesson_id = $_GET['id'];
$course_id = $_GET['course_id'];
$lessonController = new LessonController($link);
$courseController = new CourseController($link);

$course = $courseController->getCourseById($course_id);

// Ensure the teacher owns the course
if ($course['teacher_id'] != $_SESSION['id']) {
    header("location: courses.php");
    exit;
}

if ($lessonController->deleteLesson($lesson_id)) {
    header("location: manage_lessons.php?course_id=" . $course_id);
} else {
    echo "Something went wrong. Please try again later.";
}
?>
