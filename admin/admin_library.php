<!-- admin_library.php -->

<?php
include '../db/db_connect.php';

// Fetch the list of borrowed books with student names
$query = "SELECT borrowings.*, students.first_name, students.last_name, books.title AS book_title
          FROM borrowings
          INNER JOIN students ON borrowings.student_id = students.student_id
          INNER JOIN books ON borrowings.book_id = books.book_id";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Library</title>
    <link rel="stylesheet" href="CSS/styles.css">
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark bg-primary">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="students.php">Students</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="courses.php">Courses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="enrollments.php">Enrollments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="books.php">Books</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </nav>

    <div class="container">
        <h2>Admin Library</h2>

        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Borrowing ID</th>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Book ID</th>
                    <th>Book Title</th>
                    <th>Borrow Date</th>
                    <th>Return Date</th>
                    <th>Returned</th>
                    <th>Mark as Eligible</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['borrowing_id']; ?></td>
                        <td><?php echo $row['student_id']; ?></td>
                        <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                        <td><?php echo $row['book_id']; ?></td>
                        <td><?php echo $row['book_title']; ?></td>
                        <td><?php echo $row['borrow_date']; ?></td>
                        <td><?php echo $row['return_date']; ?></td>
                        <td><?php echo ($row['returned'] ? 'Returned' : 'Not Returned'); ?></td>
                        <td>
                            <input type="checkbox" name="eligible_students[]" value="<?php echo $row['student_id']; ?>">
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <button class="btn btn-primary" onclick="markEligible()">Mark as Eligible for Graduation</button>
    </div>

    <!-- Include Bootstrap JS link -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
    <script src="JS/scripts.js"></script>
    <script>
        function markEligible() {
            // Get the selected student IDs
            const checkboxes = document.querySelectorAll('input[name="eligible_students[]"]:checked');
            const studentIds = Array.from(checkboxes).map(checkbox => checkbox.value);

            // Send an AJAX request to mark students as eligible
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'mark_eligible.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Handle the response, if needed
                    location.reload(); // Refresh the page after marking as eligible
                }
            };
            xhr.send('student_ids=' + JSON.stringify(studentIds));
            alert("Student marked as eligible for graduation successfully!");
        }
    </script>
</body>
</html>
