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

// Get the book ID from the query string
if (isset($_GET['book_id'])) {
    $bookId = $_GET['book_id'];
} else {
    // Redirect to the library dashboard if book ID is not provided
    header('Location: library_dashboard.php');
    exit();
}

// Check if the book is available
$query = "SELECT * FROM books WHERE book_id = '$bookId' AND availability = 1";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // Book is available, proceed with the borrowing process
    $borrowDate = date('Y-m-d');
    $returnDate = date('Y-m-d', strtotime('+14 days')); // Assuming a 14-day borrowing period

    // Insert the borrowing record into the borrowings table
    $insertQuery = "INSERT INTO borrowings (student_id, book_id, borrow_date, return_date, returned) 
                    VALUES ('$studentId', '$bookId', '$borrowDate', '$returnDate', 0)";
    mysqli_query($conn, $insertQuery);

    // Update the availability of the book
    $updateQuery = "UPDATE books SET availability = 0 WHERE book_id = '$bookId'";
    mysqli_query($conn, $updateQuery);

    // Redirect back to the library dashboard with a success message
    header('Location: library_dashboard.php?success=borrowed');
    exit();
} else {
    // Book is not available, redirect back to the library dashboard with an error message
    header('Location: library_dashboard.php?error=unavailable');
    exit();
}
?>
