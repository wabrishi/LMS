<?php
class LessonController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getLessonsByCourse($course_id) {
        $sql = "SELECT * FROM lessons WHERE course_id = ?";
        if ($stmt = mysqli_prepare($this->db, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $course_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        return [];
    }

    public function createLesson($course_id, $title, $content, $video_url) {
        $sql = "INSERT INTO lessons (course_id, title, content, video_url) VALUES (?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($this->db, $sql)) {
            mysqli_stmt_bind_param($stmt, "isss", $course_id, $title, $content, $video_url);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }

    public function getLessonById($id) {
        $sql = "SELECT * FROM lessons WHERE id = ?";
        if ($stmt = mysqli_prepare($this->db, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            return mysqli_fetch_assoc($result);
        }
        return null;
    }

    public function updateLesson($id, $title, $content, $video_url) {
        $sql = "UPDATE lessons SET title = ?, content = ?, video_url = ? WHERE id = ?";
        if ($stmt = mysqli_prepare($this->db, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssi", $title, $content, $video_url, $id);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }

    public function deleteLesson($id) {
        $sql = "DELETE FROM lessons WHERE id = ?";
        if ($stmt = mysqli_prepare($this->db, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }
}
?>
