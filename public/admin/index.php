<?php
require_once "../../src/auth.php";
requireRole('Admin');
require_once "../../config/database.php";

// Get stats
$sql_students = "SELECT COUNT(*) as count FROM users u JOIN user_roles ur ON u.id = ur.user_id JOIN roles r ON ur.role_id = r.id WHERE r.name = 'Student'";
$result_students = mysqli_query($link, $sql_students);
$student_count = mysqli_fetch_assoc($result_students)['count'];

$sql_teachers = "SELECT COUNT(*) as count FROM users u JOIN user_roles ur ON u.id = ur.user_id JOIN roles r ON ur.role_id = r.id WHERE r.name = 'Teacher'";
$result_teachers = mysqli_query($link, $sql_teachers);
$teacher_count = mysqli_fetch_assoc($result_teachers)['count'];

$sql_courses = "SELECT COUNT(*) as count FROM courses";
$result_courses = mysqli_query($link, $sql_courses);
$course_count = mysqli_fetch_assoc($result_courses)['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://bootswatch.com/4/cerulean/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Admin Dashboard</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Students</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $student_count; ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Teachers</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $teacher_count; ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header">Courses</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $course_count; ?></h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <canvas id="myChart"></canvas>
            </div>
        </div>
        <a href="../dashboard.php" class="btn btn-secondary mt-3">Back to Main Dashboard</a>
    </div>

    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Students', 'Teachers', 'Courses'],
                datasets: [{
                    label: '# of Items',
                    data: [<?php echo $student_count; ?>, <?php echo $teacher_count; ?>, <?php echo $course_count; ?>],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
