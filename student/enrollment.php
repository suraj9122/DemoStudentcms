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

// Query the database to fetch the enrolled courses for the student
$query = "SELECT courses.course_id, courses.course_name, courses.course_details, courses.instructor_name, courses.price
          FROM enrollments
          INNER JOIN courses ON enrollments.course_id = courses.course_id
          WHERE enrollments.student_id = '$studentId'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Enrollment</title>
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
                <a class="nav-link" href="courses.php">View Courses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="view_invoice.php">View Invoice</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="enrollment.php">View Enrollment</a>
            </li>
            
            
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </nav>
    <div class="container">
        <h2>View Enrollment</h2>
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
                                <?php if ($row['price'] > 0) { ?>
                                    <?php if (hasUnpaidInvoice($studentId, $row['course_id'])) { ?>
                                        <a href="invoices.php" class="btn btn-danger">Pay Later</a>
                                    <?php } else { ?>
                                        <a href="pay_invoice.php?course_id=<?php echo $row['course_id']; ?>" class="btn btn-primary">Pay</a>
                                    <?php } ?>
                                <?php } else { ?>
                                    <button class="btn btn-secondary" disabled>N/A</button>
                                <?php } ?>
                                <a href="end_course.php?course_id=<?php echo $row['course_id']; ?>" class="btn <?php echo hasUnpaidInvoice($studentId, $row['course_id']) ? 'btn-danger' : 'btn-success'; ?> end-course-btn">End Course</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No courses enrolled.</p>
        <?php } ?>
    </div>

    <!-- Include Bootstrap JS link -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
    <script src="../JS/scripts.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var endCourseButtons = document.querySelectorAll('.end-course-btn');
        endCourseButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                var confirmation = confirm('Are you sure you want to end this course?');
                if (confirmation) {
                    window.location.href = this.getAttribute('href');
                }
            });
        });
    });
    </script>
</body>
</html>

<?php
function hasUnpaidInvoice($studentId, $courseId) {
    global $conn;
    $query = "SELECT * FROM invoices WHERE student_id = '$studentId' AND course_id = '$courseId' AND status = 'unpaid'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}
?>