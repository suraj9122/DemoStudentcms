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

// Fetch the enrolled courses for the student
$enrollmentQuery = "SELECT course_id FROM enrollments WHERE student_id = '$studentId'";
$enrollmentResult = mysqli_query($conn, $enrollmentQuery);
$enrolledCourses = array();
while ($row = mysqli_fetch_assoc($enrollmentResult)) {
    $enrolledCourses[] = $row['course_id'];
}

// Process course enrollment form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseId = $_POST['course_id'];

    // Check if the student is already enrolled in the selected course
    if (in_array($courseId, $enrolledCourses)) {
        // Redirect back to courses page with error message
        header('Location: courses.php?error=already_enrolled');
        exit();
    }

    // Enroll the student in the selected course
    $enrollQuery = "INSERT INTO enrollments (student_id, course_id) VALUES ('$studentId', '$courseId')";
    mysqli_query($conn, $enrollQuery);

    // Redirect back to courses page with success message
    header('Location: courses.php?success=enrollment_successful');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Available Courses</title>
    <link rel="stylesheet" href="../CSS/styles.css">
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand navbar-dark bg-primary">
        <a class="navbar-brand" href="dashboard.php">Dashboard</a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="profile.php">View Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="enrollment.php">View Enrollment</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="courses.php">View Courses</a>
            </li>
           
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </nav>
    <div class="container">
        <h2>Available Courses</h2>

        <?php if (isset($_GET['success']) && $_GET['success'] === 'enrollment_successful') { ?>
            <div class="alert alert-success" role="alert">
                Enrollment successful!
            </div>
        <?php } elseif (isset($_GET['error']) && $_GET['error'] === 'already_enrolled') { ?>
            <div class="alert alert-danger" role="alert">
                You are already enrolled in this course.
            </div>
        <?php } ?>

        <?php if (mysqli_num_rows($result) > 0) { ?>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th>Course Name</th>
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
                            <td><?php echo $row['course_details']; ?></td>
                            <td><?php echo $row['instructor_name']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td>
                                <?php if (in_array($row['course_id'], $enrolledCourses)) { ?>
                                    <button class="btn btn-secondary" disabled>Enrolled</button>
                                <?php } else { ?>
                                    <form method="POST" action="">
                                        <input type="hidden" name="course_id" value="<?php echo $row['course_id']; ?>">
                                        <button type="submit" class="btn btn-primary">Enroll</button>
                                    </form>
                                <?php } ?>
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
