<?php
include '../db/db_connect.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $availability = isset($_POST['availability']) ? 1 : 0;

    // Insert the new book into the database
    $insertQuery = "INSERT INTO books (title, author, category, availability) VALUES ('$title', '$author', '$category', '$availability')";
    mysqli_query($conn, $insertQuery);

    // Redirect to the books page with success message
    header('Location: books.php?success=book_added');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
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
        <h2>Add Book</h2>

        <form method="POST" action="">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" class="form-control" id="author" name="author" required>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" class="form-control" id="category" name="category" required>
            </div>
            <div class="form-group">
                <label for="availability">Availability</label>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="availability" name="availability">
                    <label class="form-check-label" for="availability">Available</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Add Book</button>
        </form>
    </div>

    <!-- Include Bootstrap JS link -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
   
    <script src="../JS/scripts.js"></script>
</body>
</html>
