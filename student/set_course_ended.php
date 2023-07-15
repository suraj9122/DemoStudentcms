<?php
session_start();
include '../db/db_connect.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}

// Get the course ID from the URL parameter
$courseId = $_GET['course_id'];



// Check if the course is already marked as ended
$query = "SELECT * FROM ended_courses WHERE course_id = '$courseId'";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    // Course is already marked as ended, so remove it from the database
    $deleteQuery = "DELETE FROM ended_courses WHERE course_id = '$courseId'";
    mysqli_query($conn, $deleteQuery);
} else {
    // Course is not marked as ended, so add it to the database
    $insertQuery = "INSERT INTO ended_courses (course_id) VALUES ('$courseId')";
    mysqli_query($conn, $insertQuery);
}

// Return a JSON response indicating success
$response = array('success' => true);
echo json_encode($response);
