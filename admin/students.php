<?php
session_start();
include '../db/db_connect.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}

// Query the database to fetch the student details
$query = "SELECT students.student_id, students.first_name, students.last_name, students.address, students.email, students.contact_number, courses.course_name AS course_enrolled
          FROM students
          LEFT JOIN enrollments ON students.student_id = enrollments.student_id
          LEFT JOIN courses ON enrollments.course_id = courses.course_id
          GROUP BY students.student_id";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Students</title>
    <link rel="stylesheet" href="../CSS/styles.css">
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark bg-primary">
        <a class="navbar-brand" href="dashboard.php">Dashboard</a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">Back to Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="graduation.php">Graduation</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </nav>

    <div class="container">
        <h2>Students</h2>

        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Contact Number</th>
                    <th>Courses Enrolled</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['student_id']; ?></td>
                        <td><?php echo $row['first_name']; ?></td>
                        <td><?php echo $row['last_name']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['contact_number']; ?></td>
                        <td><?php echo $row['course_enrolled']; ?></td>
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
