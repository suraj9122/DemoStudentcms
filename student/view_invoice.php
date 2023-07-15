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

// Query the database to fetch the invoice details for the student
$query = "SELECT invoices.invoice_id, courses.course_name, courses.price, invoices.status
          FROM invoices
          INNER JOIN courses ON invoices.course_id = courses.course_id
          WHERE invoices.student_id = '$studentId'";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>View Invoice</title>
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
                <a class="nav-link" href="invoices.php">Invoices</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </nav>

    <div class="container">
        <h2>View Invoice</h2>
        <?php if (mysqli_num_rows($result) > 0) { ?>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th>Invoice ID</th>
                        <th>Course Name</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['invoice_id']; ?></td>
                            <td><?php echo $row['course_name']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No invoices found.</p>
        <?php } ?>
    </div>

    <!-- Include Bootstrap JS link -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
    <script src="../JS/scripts.js"></script>
</body>
</html>
