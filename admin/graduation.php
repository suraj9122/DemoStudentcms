<?php
session_start();
include '../db/db_connect.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}

// Fetch the graduation eligibility data from the database
$query = "SELECT students.student_id, students.first_name, students.last_name, courses.course_id, courses.course_name, courses.price
          FROM students
          INNER JOIN enrollments ON students.student_id = enrollments.student_id
          INNER JOIN courses ON enrollments.course_id = courses.course_id
          WHERE students.graduated = 1
          AND students.student_id IN (SELECT student_id FROM invoices WHERE status = 'paid')
          GROUP BY students.student_id";
$result = mysqli_query($conn, $query);

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['studentId'];
    $courseId = $_POST['courseId'];

    // Fetch the student and course details
    $detailsQuery = "SELECT students.first_name, students.last_name, courses.course_name, courses.price
                     FROM students
                     INNER JOIN courses ON students.student_id = $studentId AND courses.course_id = $courseId";
    $detailsResult = mysqli_query($conn, $detailsQuery);
    $detailsRow = mysqli_fetch_assoc($detailsResult);

    // Insert the values into the graduates table
    $insertQuery = "INSERT INTO graduates (student_id, first_name, last_name, course_id, course_name, course_price)
                    VALUES ('$studentId', '{$detailsRow['first_name']}', '{$detailsRow['last_name']}', '$courseId', '{$detailsRow['course_name']}', '{$detailsRow['price']}')";
    mysqli_query($conn, $insertQuery);

    // Redirect to the graduation page
    header('Location: graduation.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Graduated Students</title>
    <link rel="stylesheet" href="../CSS/styles.css">
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand navbar-dark bg-primary">
        <a class="navbar-brand" href="dashboard.php">Dashboard</a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">Back to Dashboard</a>
            </li>
          
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </nav>

    <div class="container">
        <h2>Graduated Students</h2>

        <?php if (mysqli_num_rows($result) > 0) { ?>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Course ID</th>
                        <th>Course Name</th>
                        <th>Course Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['student_id']; ?></td>
                            <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                            <td><?php echo $row['course_id']; ?></td>
                            <td><?php echo $row['course_name']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td>
                                <form method="POST" action="graduation.php">
                                    <input type="hidden" name="studentId" value="<?php echo $row['student_id']; ?>">
                                    <input type="hidden" name="courseId" value="<?php echo $row['course_id']; ?>">
                                    <button type="submit" class="btn btn-primary">Mark as Graduate</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No students eligible for graduation at the moment.</p>
        <?php } ?>
    </div>

    <!-- Include Bootstrap JS link -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
    <script src="../JS/scripts.js"></script>
    <script>
        function markAsGraduate(studentId, courseId) {
  $.ajax({
    url: 'mark_graduate.php',
    type: 'POST',
    data: { studentId: studentId, courseId: courseId },
    dataType: 'json',
    success: function(response) {
      if (response.status === 'success') {
        // Show success message or perform any other action
        alert('Student marked as graduate successfully.');
       
        location.reload();
      } else {
        // Show error message or handle error condition
        alert('Failed to mark student as graduate.');
      }
    },
    error: function(xhr, status, error) {
      // Handle AJAX error condition
      console.log(error);
      alert('An error occurred while marking student as graduate.');
    }
  });
}

        </script>
</body>
</html>
