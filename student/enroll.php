<?php
session_start();
include '../db/db_connect.php';

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}

// Fetch the student's ID from the session
$studentId = $_SESSION['student_id'];

// Query the database to fetch the available courses
$query = "SELECT * FROM courses";
$result = mysqli_query($conn, $query);

// Process the enrollment form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseId = $_POST['course_id'];

    // Check if the student is already enrolled in the selected course
    $checkEnrollmentQuery = "SELECT * FROM enrollments WHERE student_id = '$studentId' AND course_id = '$courseId'";
    $checkEnrollmentResult = mysqli_query($conn, $checkEnrollmentQuery);

    if (mysqli_num_rows($checkEnrollmentResult) === 0) {
        // If not enrolled, insert the enrollment record into the database
        $enrollmentQuery = "INSERT INTO enrollments (student_id, course_id) VALUES ('$studentId', '$courseId')";
        mysqli_query($conn, $enrollmentQuery);

        // Redirect to the view enrollment page after successful enrollment
        header('Location: view_enrollment.php');
        exit();
    } else {
        // Display an error message if already enrolled in the selected course
        $enrollmentError = "You are already enrolled in this course.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enroll in Course</title>
    <link rel="stylesheet" href="../CSS/styles.css">
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Enroll in Course</h2>
        <?php if (isset($enrollmentError)) { ?>
            <div class="alert alert-danger"><?php echo $enrollmentError; ?></div>
        <?php } ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="course_id">Select Course:</label>
                <select class="form-control" id="course_id" name="course_id">
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <option value="<?php echo $row['course_id']; ?>"><?php echo $row['course_name']; ?> - <?php echo $row['price']; ?> USD</option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Enroll</button>
        </form>
    </div>

    <!-- Include Bootstrap JS link -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
    <script src="../JS/scripts.js"></script>
</body>
</html>
