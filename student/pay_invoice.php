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

// Fetch the enrollment ID from the URL parameter
if (isset($_GET['enrollment_id'])) {
    $enrollmentId = $_GET['enrollment_id'];
} else {
    // Redirect to the view enrollment page if enrollment ID is not provided
    header('Location: payment.php');
    exit();
}

// Query the database to fetch the invoice details
$query = "SELECT enrollments.*, courses.course_name, courses.price
          FROM enrollments
          INNER JOIN courses ON enrollments.course_id = courses.course_id
          WHERE enrollments.student_id = '$studentId' AND enrollments.enrollment_id = '$enrollmentId'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Process the payment form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update the invoice status to "Paid"
    $updateInvoiceQuery = "UPDATE enrollments SET invoice_paid = 1 WHERE enrollment_id = '$enrollmentId'";
    mysqli_query($conn, $updateInvoiceQuery);

    // Redirect to the view enrollment page after successful payment
    header('Location: payment.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pay Invoice</title>
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
        <h2>Pay Invoice</h2>
        <p>Course: <?php echo $row['course_name']; ?></p>
        <p>Price: <?php echo $row['price']; ?> USD</p>
        <form method="POST" action="">
            <button type="submit" class="btn btn-primary">Pay Now</button>
        </form>
        <p>Or</p>
        <p>Please pay within the next 2 days to complete the payment for graduation.</p>
    </div>

    <!-- Include Bootstrap JS link -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
    <script src="../JS/scripts.js"></script>
</body>
</html>
