<?php
session_start();
include '../db/db_connect.php';

// Check if the course manager is logged in
if (!isset($_SESSION['course_manager_id'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}

// Check if the course ID is provided as a parameter
if (!isset($_GET['course_id'])) {
    // Redirect to the dashboard if course ID is not provided
    header('Location: dashboard.php');
    exit();
}

$courseId = $_GET['course_id'];

// Query the database to fetch the course details
$query = "SELECT * FROM courses WHERE course_id = '$courseId'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseName = $_POST['course_name'];
    $daysForCompletion = $_POST['days_for_completion'];
    $courseDetails = $_POST['course_details'];
    $instructorName = $_POST['instructor_name'];
    $price = $_POST['price'];

    // Update the course in the database
    $updateQuery = "UPDATE courses SET course_name = '$courseName', days_for_completion = '$daysForCompletion', 
                    course_details = '$courseDetails', instructor_name = '$instructorName', price='$price' WHERE course_id = '$courseId'";
    mysqli_query($conn, $updateQuery);

    // Redirect to the dashboard with success message
    header('Location: dashboard.php?success=course_updated');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Course</title>
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
        <h2>Edit Course</h2>

        <form method="POST" action="">
            <div class="form-group">
                <label for="course_name">Course Name</label>
                <input type="text" class="form-control" id="course_name" name="course_name" value="<?php echo $row['course_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="days_for_completion">Number of Days for Completion</label>
                <input type="number" class="form-control" id="days_for_completion" name="days_for_completion" value="<?php echo $row['days_for_completion']; ?>" required>
            </div>
            <div class="form-group">
                <label for="course_details">Course Details</label>
                <textarea class="form-control" id="course_details" name="course_details" rows="5" required><?php echo $row['course_details']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="instructor_name">Instructor Name</label>
                <input type="text" class="form-control" id="instructor_name" name="instructor_name" value="<?php echo $row['instructor_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" class="form-control" id="price" name="price" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Course</button>
        </form>
    </div>

    <!-- Include Bootstrap JS link -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
    <script src="../JS/scripts.js"></script>
</body>
</html>
