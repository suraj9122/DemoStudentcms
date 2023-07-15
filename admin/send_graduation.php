<?php
session_start();
include '../db/db_connect.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}

// Get the student ID from the POST request
$studentId = $_POST['student_id'];

// Retrieve the enrolled course name for the student
$query = "SELECT courses.course_name
          FROM enrollments
          INNER JOIN courses ON enrollments.course_id = courses.course_id
          WHERE enrollments.student_id = '$studentId'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // Fetch the enrolled course name
    $row = mysqli_fetch_assoc($result);
    $courseName = $row['course_name'];

    

    // Display success message
    echo '<script>alert("Graduation notification sent for ' . $courseName . '");</script>';
} else {
    // Display error message
    echo '<script>alert("No enrolled course found for the student");</script>';
}

// Redirect back to the students.php page
header('Location: students.php');
exit();
?>
