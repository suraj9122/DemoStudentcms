<?php
session_start();
include '../db/db_connect.php';

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}

$studentId = $_SESSION['student_id'];
$courseId = $_GET['course_id'];
// $amount= $get_['price']
// Update the paid_status in the enrollments table to 'paid'
$updateQuery = "UPDATE enrollments SET paid_status = 1 WHERE student_id = '$studentId' AND course_id = '$courseId' ";
mysqli_query($conn, $updateQuery);

// Generate the invoice
$insertQuery = "INSERT INTO invoices (student_id, course_id,  status) VALUES ('$studentId', '$courseId', 'paid')";
mysqli_query($conn, $insertQuery);

// Redirect back to the enrollment page
header('Location: enrollment.php');
exit();
?>
