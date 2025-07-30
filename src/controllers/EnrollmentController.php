<?php
class EnrollmentController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function enrollStudent($student_id, $course_id) {
        $sql = "INSERT INTO enrollments (student_id, course_id) VALUES (?, ?)";
        if ($stmt = mysqli_prepare($this->db, $sql)) {
            mysqli_stmt_bind_param($stmt, "ii", $student_id, $course_id);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }

    public function getEnrolledCoursesByStudent($student_id) {
        $sql = "SELECT course_id FROM enrollments WHERE student_id = ?";
        if ($stmt = mysqli_prepare($this->db, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $student_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        return [];
    }
}
?>
