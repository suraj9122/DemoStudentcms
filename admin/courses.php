<?php
session_start();
include '../db/db_connect.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}

// Fetch all the courses from the database
$query = "SELECT * FROM courses";
$result = mysqli_query($conn, $query);
$courses = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Courses</title>
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
        <h2>Courses</h2>

        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Course ID</th>
                    <th>Course Name</th>
                    <th>Number of Days for Completion</th>
                    <th>Course Details</th>
                    <th>Instructor Name</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course) { ?>
                    <tr>
                        <td><?php echo $course['course_id']; ?></td>
                        <td><?php echo $course['course_name']; ?></td>
                        <td><?php echo $course['days_for_completion']; ?></td>
                        <td><?php echo $course['course_details']; ?></td>
                        <td><?php echo $course['instructor_name']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Include Bootstrap JS link -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
    <script src="../JS/scripts.js"></script>
</body>
</html>
