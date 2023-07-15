<?php
session_start();
include '../db/db_connect.php';

// Check if the course manager is logged in
if (!isset($_SESSION['course_manager_id'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseName = $_POST['course_name'];
    $daysForCompletion = $_POST['days_for_completion'];
    $courseDetails = $_POST['course_details'];
    $instructorName = $_POST['instructor_name'];
    $price = $_POST['price'];

    // Insert the new course into the database
    $insertQuery = "INSERT INTO courses (course_name, days_for_completion, course_details, instructor_name, price) 
                    VALUES ('$courseName', '$daysForCompletion', '$courseDetails', '$instructorName','$price')";
    mysqli_query($conn, $insertQuery);

    // Redirect to the dashboard with success message
    header('Location: dashboard.php?success=course_added');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Course</title>
    <link rel="stylesheet" href="../CSS/styles.css">
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark bg-primary">
        <a class="navbar-brand" href="#">Dashboard</a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">Back to Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </nav>

    <div class="container">
        <h2>Add Course</h2>

        <form method="POST" action="">
            <div class="form-group">
                <label for="course_name">Course Name</label>
                <input type="text" class="form-control" id="course_name" name="course_name" required>
            </div>
            <div class="form-group">
                <label for="days_for_completion">Number of Days for Completion</label>
                <input type="number" class="form-control" id="days_for_completion" name="days_for_completion" required>
            </div>
            <div class="form-group">
                <label for="course_details">Course Details</label>
                <textarea class="form-control" id="course_details" name="course_details" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="instructor_name">Instructor Name</label>
                <input type="text" class="form-control" id="instructor_name" name="instructor_name" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" class="form-control" id="price" name="price" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Course</button>
        </form>
    </div>

    <!-- Include Bootstrap JS link -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
    <script src="../JS/scripts.js"></script>
</body>
</html>
