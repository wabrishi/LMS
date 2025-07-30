<?php
require_once "../../src/auth.php";
requireRole('Student');
require_once "../../config/database.php";
require_once "../../src/controllers/CourseController.php";
require_once "../../src/controllers/LessonController.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("location: courses.php");
    exit;
}

$courseController = new CourseController($link);
$lessonController = new LessonController($link);

$course_id = $_GET['id'];
$course = $courseController->getCourseById($course_id);
$lessons = $lessonController->getLessonsByCourse($course_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($course['title']); ?></title>
    <link rel="stylesheet" href="https://bootswatch.com/4/cerulean/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-5"><?php echo htmlspecialchars($course['title']); ?></h2>
        <p><?php echo htmlspecialchars($course['description']); ?></p>
        <hr>
        <h3>Lessons</h3>
        <div class="list-group">
            <?php foreach ($lessons as $lesson): ?>
                <div class="list-group-item">
                    <h5><?php echo htmlspecialchars($lesson['title']); ?></h5>
                    <p><?php echo nl2br(htmlspecialchars($lesson['content'])); ?></p>
                    <?php if (!empty($lesson['video_url'])): ?>
                        <?php
                        // Function to extract YouTube video ID from URL
                        function getYouTubeVideoId($url) {
                            $video_id = false;
                            $url_parts = parse_url($url);
                            if (isset($url_parts['query'])) {
                                parse_str($url_parts['query'], $query_params);
                                if (isset($query_params['v'])) {
                                    $video_id = $query_params['v'];
                                }
                            } elseif (isset($url_parts['path'])) {
                                $path_parts = explode('/', $url_parts['path']);
                                $video_id = end($path_parts);
                            }
                            return $video_id;
                        }

                        $video_id = getYouTubeVideoId($lesson['video_url']);
                        if ($video_id):
                        ?>
                        <div class="embed-responsive embed-responsive-16by9 mt-3">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo htmlspecialchars($video_id); ?>" allowfullscreen></iframe>
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="courses.php" class="btn btn-secondary mt-3">Back to Courses</a>
    </div>
</body>
</html>
