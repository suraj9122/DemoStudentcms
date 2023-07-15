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

// Query the database to fetch the student's profile
$query = "SELECT * FROM students WHERE student_id = '$studentId'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Query the database to fetch the unpaid invoices count for the student
$unpaidInvoiceQuery = "SELECT COUNT(*) AS unpaid_count FROM invoices WHERE student_id = '$studentId' AND status = 'unpaid'";
$unpaidInvoiceResult = mysqli_query($conn, $unpaidInvoiceQuery);
$unpaidCount = mysqli_fetch_assoc($unpaidInvoiceResult)['unpaid_count'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../CSS/styles.css">
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        /* Custom CSS for the table */
        .table {
            background-color: #f8f9fa;
            color: #343a40;
        }

        .table thead th {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        .table td,
        .table th {
            border: 1px solid #dee2e6;
            padding: 8px;
            vertical-align: top;
        }

        @media (max-width: 767px) {
            .table-responsive-sm {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark bg-primary">
        <a class="navbar-brand" href="#">Dashboard</a>
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
                <a class="nav-link" href="library_dashboard.php">Library</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="result.php">Result</a>
            </li>
            <?php if ($unpaidCount > 0) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="invoices.php">View Invoices (<?php echo $unpaidCount; ?>)</a>
                </li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </nav>
    <div class="container">
        <h2>Welcome, <?php echo $row['first_name']; ?>!</h2>
        <h3>Enrolled Courses:</h3>
        <?php
        // Query the database to fetch the enrolled courses for the student
        $enrollmentQuery = "SELECT courses.course_name, courses.course_details, courses.instructor_name
                            FROM enrollments
                            INNER JOIN courses ON enrollments.course_id = courses.course_id
                            WHERE enrollments.student_id = '$studentId'";
        $enrollmentResult = mysqli_query($conn, $enrollmentQuery);

        if (mysqli_num_rows($enrollmentResult) > 0) {
            echo '<div class="table-responsive-sm">';
            echo '<table class="table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Course Name</th>';
            echo '<th>Course Details</th>';
            echo '<th>Instructor Name</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($enrollmentRow = mysqli_fetch_assoc($enrollmentResult)) {
                echo '<tr>';
                echo '<td>' . $enrollmentRow['course_name'] . '</td>';
                echo '<td>' . $enrollmentRow['course_details'] . '</td>';
                echo '<td>' . $enrollmentRow['instructor_name'] . '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        } else {
            echo '<p>No courses enrolled.</p>';
        }
        ?>
    </div>

    <!-- Include Bootstrap JS link -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
    <script src="../JS/scripts.js"></script>
</body>
</html>

