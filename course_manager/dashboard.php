<?php
session_start();
include '../db/db_connect.php';

// Check if the course manager is logged in
if (!isset($_SESSION['course_manager_id'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}

// Fetch the course manager's ID from the session
$courseManagerId = $_SESSION['course_manager_id'];

// Query the database to fetch the course manager's details
$courseManagerQuery = "SELECT * FROM course_managers WHERE course_manager_id = '$courseManagerId'";
$courseManagerResult = mysqli_query($conn, $courseManagerQuery);
$courseManagerRow = mysqli_fetch_assoc($courseManagerResult);
$courseManagerName = $courseManagerRow['first_name'] . ' ' . $courseManagerRow['last_name'];

// Query the database to fetch all the courses
$query = "SELECT * FROM courses";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Course Manager Dashboard</title>
    <link rel="stylesheet" href="../CSS/styles.css">
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark bg-primary">
        <a class="navbar-brand" href="#">Dashboard</a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="add_course.php">Add Course</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </nav>

    <div class="container">
        <h2>Welcome, <?php echo $courseManagerName; ?>!</h2>
        <h3>Course Details</h3>
        
        <?php if (mysqli_num_rows($result) > 0) { ?>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th>Course Name</th>
                        <th>Number of Days for Completion</th>
                        <th>Course Details</th>
                        <th>Instructor Name</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['course_name']; ?></td>
                            <td><?php echo $row['days_for_completion']; ?></td>
                            <td><?php echo $row['course_details']; ?></td>
                            <td><?php echo $row['instructor_name']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td>
                                <a href="edit_course.php?course_id=<?php echo $row['course_id']; ?>" class="btn btn-primary">Edit</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No courses available.</p>
        <?php } ?>
    </div>

    <!-- Include Bootstrap JS link -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
    <script src="../JS/scripts.js"></script>
</body>
</html>
