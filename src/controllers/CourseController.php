<?php
class CourseController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllCourses() {
        $sql = "SELECT c.id, c.title, u.username as teacher_name FROM courses c LEFT JOIN users u ON c.teacher_id = u.id";
        $result = mysqli_query($this->db, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getCourseById($id) {
        $sql = "SELECT * FROM courses WHERE id = ?";
        if ($stmt = mysqli_prepare($this->db, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            return mysqli_fetch_assoc($result);
        }
        return null;
    }

    public function createCourse($title, $description, $teacher_id) {
        $sql = "INSERT INTO courses (title, description, teacher_id) VALUES (?, ?, ?)";
        if ($stmt = mysqli_prepare($this->db, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssi", $title, $description, $teacher_id);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }

    public function updateCourse($id, $title, $description, $teacher_id) {
        $sql = "UPDATE courses SET title = ?, description = ?, teacher_id = ? WHERE id = ?";
        if ($stmt = mysqli_prepare($this->db, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssii", $title, $description, $teacher_id, $id);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }

    public function deleteCourse($id) {
        $sql = "DELETE FROM courses WHERE id = ?";
        if ($stmt = mysqli_prepare($this->db, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }

    public function getAllTeachers() {
        $sql = "SELECT u.id, u.username FROM users u JOIN user_roles ur ON u.id = ur.user_id JOIN roles r ON ur.role_id = r.id WHERE r.name = 'Teacher'";
        $result = mysqli_query($this->db, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getCoursesByTeacher($teacher_id) {
        $sql = "SELECT * FROM courses WHERE teacher_id = ?";
        if ($stmt = mysqli_prepare($this->db, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $teacher_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        return [];
    }
}
?>
