<?php
session_start();
include '../db/db_connect.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}

// Query the database to fetch the enrollments with student and course details
$query = "SELECT enrollments.enrollment_id, students.first_name, students.last_name, courses.course_name, enrollments.paid_status
          FROM enrollments
          INNER JOIN students ON enrollments.student_id = students.student_id
          INNER JOIN courses ON enrollments.course_id = courses.course_id";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enrollments</title>
    <link rel="stylesheet" href="../CSS/styles.css">
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark bg-primary">
        <a class="navbar-brand" href="dashboard.php">Dashboard</a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="students.php">View Students</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="courses.php">View Courses</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="enrollments.php">View Enrollments</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </nav>

    <div class="container">
        <h2>Enrollments</h2>
        <?php if (mysqli_num_rows($result) > 0) { ?>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th>Enrollment ID</th>
                        <th>Student Name</th>
                        <th>Course Name</th>
                        <th>Paid Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['enrollment_id']; ?></td>
                            <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                            <td><?php echo $row['course_name']; ?></td>
                            <td><?php echo $row['paid_status'] ? 'Paid' : 'Unpaid'; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No enrollments found.</p>
        <?php } ?>
    </div>

    <!-- Include Bootstrap JS link -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
    <script src="../JS/scripts.js"></script>
</body>
</html>
