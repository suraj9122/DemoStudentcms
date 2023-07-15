<?php
include '../db/db_connect.php';

// Check if the book ID is provided
if (isset($_GET['book_id'])) {
    $bookId = $_GET['book_id'];

    // Fetch the book details from the database
    $query = "SELECT * FROM books WHERE book_id = '$bookId'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $title = $row['title'];
        $author = $row['author'];
        $category = $row['category'];
        $availability = $row['availability'];
    } else {
        // Book not found, redirect to the books page
        header('Location: books.php');
        exit();
    }
} else {
    // Book ID not provided, redirect to the books page
    header('Location: books.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $availability = isset($_POST['availability']) ? 1 : 0;

    // Update the book details in the database
    $updateQuery = "UPDATE books SET title = '$title', author = '$author', category = '$category', availability = '$availability' WHERE book_id = '$bookId'";
    mysqli_query($conn, $updateQuery);

    // Redirect to the books page with success message
    header('Location: books.php?success=book_updated');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
    <link rel="stylesheet" href="../CSS/styles.css">
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark bg-primary">
        <a class="navbar-brand" href="#">Library</a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="books.php">Back to Books</a>
            </li>
        </ul>
    </nav>

    <div class="container">
        <h2>Edit Book</h2>

        <form method="POST" action="">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>" required>
            </div>
            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" class="form-control" id="author" name="author" value="<?php echo $author; ?>" required>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" class="form-control" id="category" name="category" value="<?php echo $category; ?>" required>
            </div>
            <div class="form-group">
                <label for="availability">Availability</label>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="availability" name="availability" <?php echo $availability ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="availability">Available</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Book</button>
        </form>
    </div>

    <!-- Include Bootstrap JS link -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
    <script src="../JS/scripts.js"></script>
</body>
</html>
