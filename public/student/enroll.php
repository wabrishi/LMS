<?php
require_once "../../src/auth.php";
requireRole('Student');
require_once "../../config/database.php";
require_once "../../src/controllers/EnrollmentController.php";

$enrollmentController = new EnrollmentController($link);

if (isset($_GET['course_id']) && !empty($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
    $student_id = $_SESSION['id'];

    if ($enrollmentController->enrollStudent($student_id, $course_id)) {
        header("location: courses.php");
    } else {
        echo "Something went wrong. Please try again later.";
    }
} else {
    header("location: courses.php");
    exit;
}
?>
