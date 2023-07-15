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

// Get the borrowing ID from the query string
if (isset($_GET['borrowing_id'])) {
    $borrowingId = $_GET['borrowing_id'];
} else {
    // Redirect to the library dashboard if borrowing ID is not provided
    header('Location: library_dashboard.php');
    exit();
}

// Check if the borrowing record exists and belongs to the student
$query = "SELECT * FROM borrowings WHERE borrowing_id = '$borrowingId' AND student_id = '$studentId'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // Update the borrowing record to mark the book as returned
    $updateQuery = "UPDATE borrowings SET returned = 1 WHERE borrowing_id = '$borrowingId'";
    mysqli_query($conn, $updateQuery);

    // Get the book ID associated with the borrowing record
    $bookQuery = "SELECT book_id FROM borrowings WHERE borrowing_id = '$borrowingId'";
    $bookResult = mysqli_query($conn, $bookQuery);
    $bookRow = mysqli_fetch_assoc($bookResult);
    $bookId = $bookRow['book_id'];

    // Update the availability of the book
    $updateBookQuery = "UPDATE books SET availability = 1 WHERE book_id = '$bookId'";
    mysqli_query($conn, $updateBookQuery);

    // Redirect back to the library dashboard with a success message
    header('Location: library_dashboard.php?success=returned');
    exit();
} else {
    // Redirect back to the library dashboard with an error message
    header('Location: library_dashboard.php?error=invalid_borrowing');
    exit();
}
?>
