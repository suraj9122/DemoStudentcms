<?php
session_start();
include '../db/db_connect.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}

// Fetch the admin's ID from the session
$adminId = $_SESSION['admin_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../CSS/styles.css">
    <!-- Include Bootstrap CSS link -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #FF7F50; /* Coral background */
            color: #FFFFFF; /* White text color */
        }

        .container {
            background-color: rgba(0, 0, 0, 0.6); /* Semi-transparent black container background */
            padding: 20px;
            margin-top: 50px;
            border-radius: 10px;
        }

        h2, h3 {
            color: #FFD700; /* Gold heading color */
        }

        .navbar {
            background-color: #FF8C00; /* Dark orange navbar background */
        }

        .nav-link {
            color: #FFFFFF; /* White navbar link color */
        }

        #courseChart {
            background-color: #000000; /* Black background for chart */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark bg-primary">
        <a class="navbar-brand" href="#">Dashboard</a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="students.php">Students</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="courses.php">Courses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="enrollments.php">Enrollments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin_library.php">Library</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </nav>

    <div class="container">
        <h2>Welcome, Admin!</h2>
        <div class="container">
            <h3>Number of Students in Each Course</h3>
            <canvas id="courseChart"></canvas>
        </div>
    </div>

    <!-- Include Bootstrap JS link -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
    <script src="../JS/scripts.js"></script>

</body>
</html>

