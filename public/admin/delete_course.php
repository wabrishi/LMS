<?php
require_once "../../src/auth.php";
requireRole('Admin');
require_once "../../config/database.php";
require_once "../../src/controllers/CourseController.php";

$courseController = new CourseController($link);

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $course_id = $_GET['id'];
    if ($courseController->deleteCourse($course_id)) {
        header("location: courses.php");
    } else {
        echo "Something went wrong. Please try again later.";
    }
} else {
    header("location: courses.php");
    exit;
}
?>
