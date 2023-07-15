<!-- library_dashboard.php -->

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

// Get the success/error messages, if any
$success = isset($_GET['success']) ? $_GET['success'] : '';
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Library Dashboard</title>
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
                <a class="nav-link" href="library_dashboard.php">Library</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </nav>

    <div class="container">
        <h2>Library Dashboard</h2>

        <?php if ($success === 'borrowed') { ?>
            <div class="alert alert-success">Book borrowed successfully!</div>
        <?php } elseif ($success === 'returned') { ?>
            <div class="alert alert-success">Book returned successfully!</div>
        <?php } elseif ($error === 'unavailable') { ?>
            <div class="alert alert-danger">Book is not available for borrowing.</div>
        <?php } elseif ($error === 'invalid_borrowing') { ?>
            <div class="alert alert-danger">Invalid borrowing record.</div>
        <?php } ?>

        <form class="form-inline my-4" onsubmit="event.preventDefault(); searchBooks();">
            <input class="form-control mr-sm-2" type="text" id="search" placeholder="Search">
            <button class="btn btn-primary" type="submit">Search</button>
        </form>

        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Availability</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch the books from the database
                $query = "SELECT * FROM books";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    $bookId = $row['book_id'];
                    $title = $row['title'];
                    $author = $row['author'];
                    $category = $row['category'];
                    $availability = $row['availability'];

                    $borrowButtonText = $availability ? 'Borrow' : 'Not Available';
                    $borrowButtonClass = $availability ? 'btn-primary' : 'btn-secondary';
                ?>
                    <tr>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $author; ?></td>
                        <td><?php echo $category; ?></td>
                        <td><?php echo $availability ? 'Available' : 'Borrowed'; ?></td>
                        <td>
                            <?php if ($availability) { ?>
                                <a href="borrow_book.php?book_id=<?php echo $bookId; ?>" class="btn <?php echo $borrowButtonClass; ?>"><?php echo $borrowButtonText; ?></a>
                            <?php } else { ?>
                                <a href="#" class="btn btn-secondary" disabled><?php echo $borrowButtonText; ?></a>
                            <?php } ?>

                            <?php
// Check if the student has borrowed this book
$borrowedQuery = "SELECT * FROM borrowings WHERE student_id = '$studentId' AND book_id = '$bookId' AND returned = 0";
$borrowedResult = mysqli_query($conn, $borrowedQuery);

if (mysqli_num_rows($borrowedResult) > 0) {
    $borrowingRow = mysqli_fetch_assoc($borrowedResult);
    $borrowingId = $borrowingRow['borrowing_id'];
    ?>
    <a href="return_book.php?borrowing_id=<?php echo $borrowingId; ?>" class="btn btn-danger">Return</a>
<?php } ?>
</td>
</tr>
<?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Include Bootstrap JS link -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
    <script src="../JS/scripts.js"></script>
    <!-- Add the following script tag after including Bootstrap JS -->
<script>
    // Function to filter the table rows based on the search input
    function searchBooks() {
        // Get the search input value
        var input = document.getElementById("search").value.toUpperCase();

        // Get the table rows
        var rows = document.getElementsByTagName("tr");

        // Loop through the table rows and hide/show based on the search input
        for (var i = 1; i < rows.length; i++) {
            var title = rows[i].getElementsByTagName("td")[1].innerText.toUpperCase();
            var author = rows[i].getElementsByTagName("td")[2].innerText.toUpperCase();
            var category = rows[i].getElementsByTagName("td")[3].innerText.toUpperCase();

            if (title.includes(input) || author.includes(input) || category.includes(input)) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    }
</script>

</body>
</html>
