<?php
include '../db/db_connect.php';

// Fetch all books from the database
$query = "SELECT * FROM books";
$result = mysqli_query($conn, $query);

// Handle book deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $bookId = $_POST['delete'];
    
    // Delete the book from the database
    $deleteQuery = "DELETE FROM books WHERE book_id = '$bookId'";
    mysqli_query($conn, $deleteQuery);
    
    // Redirect to the books page to reflect the changes
    header('Location: books.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Books</title>
    <link rel="stylesheet" href="../CSS/styles.css">
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark bg-primary">
        <a class="navbar-brand" href="#">Library</a>
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
        <h2>Books</h2>

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
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['author']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><?php echo $row['availability'] ? 'Available' : 'Not Available'; ?></td>
                        <td>
                            <a href="edit_book.php?book_id=<?php echo $row['book_id']; ?>" class="btn btn-primary">Edit</a>
                            <form method="POST" action="">
                                <input type="hidden" name="delete" value="<?php echo $row['book_id']; ?>">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <a href="add_book.php" class="btn btn-primary">Add Book</a>
    </div>

    <!-- Include Bootstrap JS link -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
    <script src="../JS/scripts.js"></script>
</body>
</html>
