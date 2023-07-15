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

// Process profile update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $contactNumber = $_POST['contact_number'];
    $address = $_POST['address'];
    $university = $_POST['university'];

    // Update the student's profile in the database
    $updateQuery = "UPDATE students SET first_name = '$firstName', last_name = '$lastName', 
                    contact_number = '$contactNumber', address = '$address', university = '$university' 
                    WHERE student_id = '$studentId'";
    mysqli_query($conn, $updateQuery);

    // Refresh the page to display updated profile details
    header('Location: profile.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Profile</title>
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
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </nav>
    <div class="container">
        <h2>View Profile</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $row['first_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $row['last_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="contact_number">Contact Number:</label>
                <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo $row['contact_number']; ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo $row['address']; ?>" required>
            </div>
            <div class="form-group">
                <label for="university">University:</label>
                <input type="text" class="form-control" id="university" name="university" value="<?php echo $row['university']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>

    <!-- Include Bootstrap JS link -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
    <script src="../JS/scripts.js"></script>
</body>
</html>
