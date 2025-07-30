<?php
if (file_exists('../../config.php')) {
    header('Location: step6.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LMS Installation - Step 5</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Configuration File Not Found</h1>
        <p>The <code>config.php</code> file was not found in the root directory. Please go back and create the file as instructed.</p>
        <a href="step4.php" class="btn btn-danger">Back</a>
    </div>
</body>
</html>
